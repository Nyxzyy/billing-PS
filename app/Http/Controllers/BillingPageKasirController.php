<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Device;
use App\Models\BillingPackage;
use App\Models\TransactionReport;
use App\Models\CashierReport;
use App\Models\OpenBillingPromo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Process\Process;
use Carbon\Carbon;

class BillingPageKasirController extends Controller
{
    public function Devices()
    {
        $now = Carbon::now();

        // Hanya auto-off untuk paket non-Open Billing
        $expiredDevices = Device::where('status', 'Berjalan')
            ->whereNotNull('shutdown_time')
            ->where('package', '!=', 'Open Billing')
            ->get();

        foreach ($expiredDevices as $device) {
            if (Carbon::parse($device->shutdown_time)->lte($now)) {
                // Matikan plug
                $script = base_path('resources/js/tapo_control.js');
                $process = new Process(['node', $script, 'off', $device->ip_address]);
                $process->run();
                if (!$process->isSuccessful()) {
                    Log::error('Auto OFF gagal', ['device_id' => $device->id, 'error' => $process->getErrorOutput()]);
                } else {
                    Log::info('Auto OFF berhasil', ['device_id' => $device->id]);
                }

                // Update status di DB
                $device->update([
                    'status'        => 'Tersedia',
                    'package'       => null,
                    'shutdown_time' => null,
                    'last_used_at'  => null,
                ]);
            }
        }

        // Ambil data untuk tampilan
        $devices = Device::all()->sortBy(fn($d) => preg_match('/(\d+)/',$d->name,$m)?$m[1]:$d->name);
        $days = [1=>'Senin',2=>'Selasa',3=>'Rabu',4=>'Kamis',5=>'Jumat',6=>'Sabtu',7=>'Minggu'];
        $dow  = $now->dayOfWeek ?: 7;
        $today = $days[$dow];
        $time  = $now->format('H:i:s');

        $packages = BillingPackage::whereJsonContains('active_days', $today)
            ->where(fn($q) =>
                $q->where(fn($q) =>
                    $q->where('active_hours_start','<=',$time)
                      ->where('active_hours_end','>=',$time)
                )
                ->orWhere(fn($q) =>
                    $q->where('active_hours_start','>','active_hours_end')
                      ->where(fn($q) =>
                          $q->where('active_hours_start','<=',$time)
                            ->orWhere('active_hours_end','>=',$time)
                      )
                )
            )
            ->get();

        return view('kasir.billing', compact('devices','packages'));
    }


    public function addBilling(Request $req)
    {
        try {
            // Menambah waktu paket tanpa langsung menyalakan plug
            $v = $req->validate([
                'device_id'  => 'required|exists:devices,id',
                'package_id' => 'required|exists:billing_packages,id',
                'is_adding'  => 'required|boolean',
            ]);

            $device = Device::findOrFail($v['device_id']);
            $shift  = CashierReport::where('cashier_id', Auth::id())
                                   ->whereNull('shift_end')
                                   ->firstOrFail();
            $pkg    = BillingPackage::findOrFail($v['package_id']);

            $mins     = $pkg->duration_hours * 60 + $pkg->duration_minutes;
            $now      = Carbon::now();
            $shutdown = $device->shutdown_time ? Carbon::parse($device->shutdown_time) : null;
            $newShut  = ($v['is_adding'] && $shutdown?->isFuture())
                       ? $shutdown->addMinutes($mins)
                       : $now->copy()->addMinutes($mins);

            DB::beginTransaction();
            $trx = TransactionReport::create([
                'device_id'    => $device->id,
                'user_id'      => Auth::id(),
                'package_name' => $pkg->package_name,
                'package_time' => $mins,
                'start_time'   => $now,
                'end_time'     => $newShut,
                'total_price'  => $pkg->total_price,
            ]);

            $device->update([
                'status'        => 'Berjalan',
                'package'       => $pkg->package_name,
                'shutdown_time' => $newShut,
                'last_used_at'  => $now,
            ]);

            $shift->increment('total_transactions');
            $shift->increment('total_revenue', $pkg->total_price);
            DB::commit();

            return response()->json([
                'message'        => 'Waktu paket berhasil ditambah',
                'status'         => 'Berjalan',
                'transaction_id' => $trx->id,
                'shutdown_time'  => $newShut->toIso8601String(),
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Add Billing Error', ['error' => $e->getMessage()]);
            return response()->json([
                'message' => 'Terjadi kesalahan saat menambah paket',
                'status'  => 'error'
            ], 500);
        }
    }

    public function startBilling(Request $req)
    {
        try {
            $v = $req->validate([
                'device_id'=>'required|exists:devices,id',
                'package_id'=>'nullable|exists:billing_packages,id',
                'is_open'=>'required|boolean',
            ]);

            $device = Device::findOrFail($v['device_id']);
            $shift  = CashierReport::where('cashier_id',Auth::id())->whereNull('shift_end')->firstOrFail();
            $now    = Carbon::now();
            $newShutdown = null;
            $pkgName = 'Open Billing';
            $pkgTime = null;
            $price   = 0;

            if (!$v['is_open']) {
                $pkg = BillingPackage::findOrFail($v['package_id']);
                $pkgTime     = $pkg->duration_hours*60 + $pkg->duration_minutes;
                $newShutdown = $now->copy()->addMinutes($pkgTime);
                $pkgName     = $pkg->package_name;
                $price       = $pkg->total_price;
            } else {
                BillingOpen::firstOrFail();
            }

            DB::beginTransaction();
            $trx = TransactionReport::create([
                'device_id'=>$device->id,
                'user_id'=>Auth::id(),
                'package_name'=>$pkgName,
                'package_time'=>$pkgTime,
                'start_time'=>$now,
                'end_time'=>$newShutdown,
                'total_price'=>$price,
            ]);
            $device->update(['status'=>'Berjalan','package'=>$pkgName,'shutdown_time'=>$newShutdown,'last_used_at'=>$now]);
            $shift->increment('total_transactions');
            $shift->increment('total_revenue',$price);
            DB::commit();

            // Nyalakan plug untuk semua jenis paket
            $script = base_path('resources/js/tapo_control.js');
            $process = new Process(['node',$script,'on',$device->ip_address]);
            $process->run();
            if(!$process->isSuccessful()) Log::error('Tapo ON gagal',['error'=>$process->getErrorOutput()]);
            else Log::info('Tapo ON berhasil',['output'=>$process->getOutput()]);

            return response()->json(['message'=>'Billing dimulai dan plug menyala','status'=>'Berjalan','transaction_id'=>$trx->id,'shutdown_time'=>$newShutdown?->toIso8601String()]);
        } catch(\Throwable $e) {
            DB::rollBack();
            Log::error('Start Billing Error',['error'=>$e->getMessage()]);
            return response()->json(['message'=>'Terjadi kesalahan saat memulai billing','status'=>'error'],500);
        }
    }

    public function finishBilling(Request $req)
    {
        try {
            $v=$req->validate(['device_id'=>'required|exists:devices,id']);
            $device = Device::findOrFail($v['device_id']);
            $now=Carbon::now();

            // Untuk paket non-open, auto-off sudah di Devices()
            // Untuk Open Billing, tunggu tombol selesai—tidak auto mati
            $script = base_path('resources/js/tapo_control.js');
            $process = new Process(['node', $script, 'off', $device->ip_address]);
            $process->run();
            if (!$process->isSuccessful()) {
            Log::error('Tapo OFF gagal', ['error' => $process->getErrorOutput()]);
            } else {
            Log::info('Tapo OFF berhasil', ['output' => $process->getOutput()]);
        }


            $trx=TransactionReport::where('device_id',$device->id)->whereNull('end_time')->latest()->first();
            if($trx){
                $end=($device->shutdown_time && $now->gte($device->shutdown_time))?$device->shutdown_time:$now;
                $start=Carbon::parse($trx->start_time);
                if($end->lt($start)) $end=$start->copy();
                $dur=$start->diffInMinutes($end);
                $trx->update(['end_time'=>$end,'package_time'=>$dur]);
            }

            $device->update(['status'=>'Tersedia','package'=>null,'shutdown_time'=>null,'last_used_at'=>null]);
            return response()->json(['message'=>'Billing selesai','status'=>'success','transaction'=>$trx?->only(['id','start_time','end_time','package_time','total_price'])]);
        }catch(\Throwable $e){
            Log::error('Finish Billing Error',['error'=>$e->getMessage()]);
            return response()->json(['message'=>'Terjadi kesalahan saat menyelesaikan billing','status'=>'error'],500);
        }
    }
    public function updateDeviceStatus(Request $req)
    {
        try {
            $v = $req->validate([
                'device_id'=>'required|exists:devices,id',
                'status'=>'required|string|in:Tersedia,Berjalan,Pending,Selesai,Maintenance',
                'server_time'=>'nullable|date',
            ]);

            $device = Device::findOrFail($v['device_id']);
            $old    = $device->status;
            $device->status = $v['status'];

            if ($v['status'] === 'Tersedia') {
                $device->package = null;
                $device->shutdown_time = null;
                $device->last_used_at = null;
            }

            $device->save();

            Log::info('Device status updated',[ 'id'=>$device->id,'from'=>$old,'to'=>$device->status,'server_time'=>$v['server_time'] ]);

            return response()->json([ 'message'=>'Status updated','status'=>'success','device'=>$device ]);
        } catch (\Throwable $e) {
            Log::error('Update Status Error',['error'=>$e->getMessage()]);
            return response()->json([ 'message'=>'Error updating status','status'=>'error' ],500);
        }
    }

    public function getServerTime()
    {
        return response()->json([ 'timestamp'=>Carbon::now()->toIso8601String(),'timezone'=>config('app.timezone') ]);
    }

    public function checkAndShutdown()
{
    $now = Carbon::now();

    $expiredDevices = Device::where('status', 'Berjalan')
        ->whereNotNull('shutdown_time')
        ->where('package', '!=', 'Open Billing')
        ->get();

    foreach ($expiredDevices as $device) {
        if (Carbon::parse($device->shutdown_time)->lte($now)) {
            $script = base_path('resources/js/tapo_control.js');
            $process = new Process(['node', $script, 'off', $device->ip_address]);
            $process->run();
            if (!$process->isSuccessful()) {
                Log::error('Auto OFF gagal', ['device_id' => $device->id, 'error' => $process->getErrorOutput()]);
            } else {
                Log::info('Auto OFF berhasil', ['device_id' => $device->id]);
            }

            $device->update([
                'status'        => 'Tersedia',
                'package'       => null,
                'shutdown_time' => null,
                'last_used_at'  => null,
            ]);
        }
    }

    return response()->json(['message' => 'Checked and updated shutdowns if needed']);
}

}
