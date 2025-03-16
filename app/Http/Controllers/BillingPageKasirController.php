<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Device;
use App\Models\BillingPackage;
use App\Models\TransactionReport;
use App\Models\BillingOpen;
use App\Models\CashierReport;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BillingPageKasirController extends Controller
{

    public function Devices()
    {
        $devices = Device::all()->sortBy(function($device) {
            preg_match('/(\d+)/', $device->name, $matches);
            return $matches[1] ?? $device->name;
        });
        
        $packages = BillingPackage::all();
        
        return view('kasir.billing', compact('devices', 'packages'));
    }

    public function addBilling(Request $request)
    {
        try {
            $validated = $request->validate([
                'device_id' => 'required|exists:devices,id',
                'package_id' => 'required|exists:billing_packages,id',
                'is_adding' => 'required|boolean'
            ]);

            $device = Device::find($request->device_id);

            if (!$device) {
                return response()->json([
                    'message' => 'Device tidak ditemukan',
                    'status' => 'error'
                ], 404);
            }

            // Check for active shift
            $today = Carbon::now()->format('Y-m-d');
            $currentShift = CashierReport::where('cashier_id', Auth::id())
                ->whereDate('work_date', $today)
                ->whereNull('shift_end')
                ->first();

            if (!$currentShift) {
                return response()->json([
                    'message' => 'Tidak ada shift aktif. Silakan mulai shift terlebih dahulu.',
                    'status' => 'error',
                    'needShift' => true
                ], 400);
            }

            $package = BillingPackage::find($request->package_id);
            if (!$package) {
                return response()->json([
                    'message' => 'Paket tidak ditemukan',
                    'status' => 'error'
                ], 404);
            }

            $additionalMinutes = ($package->duration_hours * 60) + $package->duration_minutes;
            $currentTime = now();
            
            if ($device->shutdown_time) {
                $shutdownTime = \Carbon\Carbon::parse($device->shutdown_time);
                
                if ($request->is_adding && $shutdownTime->isFuture()) {
                    \Log::info('Adding time to existing future shutdown time');
                    $newShutdownTime = $shutdownTime->copy()->addMinutes($additionalMinutes);
                } else {
                    \Log::info('Starting new time from current moment');
                    $newShutdownTime = $currentTime->copy()->addMinutes($additionalMinutes);
                }
            } else {
                \Log::info('No shutdown time set, using current time');
                $newShutdownTime = $currentTime->copy()->addMinutes($additionalMinutes);
            }

            DB::beginTransaction();
            try {
                // Create transaction record
                $transaction = TransactionReport::create([
                    'device_id' => $device->id,
                    'user_id' => Auth::id(),
                    'package_name' => $package->package_name,
                    'package_time' => $additionalMinutes,
                    'start_time' => $currentTime,
                    'end_time' => $newShutdownTime,
                    'total_price' => $package->total_price,
                    'status' => 'active'
                ]);

                // Update device status
                $device->status = 'Berjalan';
                $device->package = $package->package_name;
                $device->shutdown_time = $newShutdownTime;
                $device->last_used_at = $currentTime;
                $device->save();

                // Update shift totals
                $currentShift->increment('total_transactions');
                $currentShift->increment('total_revenue', $package->total_price);

                DB::commit();

                return response()->json([
                    'message' => 'Billing berhasil ditambahkan',
                    'status' => $device->status,
                    'shutdown_time' => $newShutdownTime->format('Y-m-d H:i:s')
                ]);

            } catch (\Exception $e) {
                DB::rollback();
                throw $e;
            }
            
        } catch (\Exception $e) {
            \Log::error('Add Billing Error:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'message' => 'Terjadi kesalahan saat menambah billing',
                'status' => 'error'
            ], 500);
        }
    }

    public function startBilling(Request $request)
    {
        try {
            $validated = $request->validate([
                'device_id' => 'required|exists:devices,id',
                'package_id' => 'nullable|exists:billing_packages,id',
                'is_open' => 'required|boolean'
            ]);

            $device = Device::find($request->device_id);
            
            if (!$device) {
                return response()->json([
                    'message' => 'Device tidak ditemukan',
                    'status' => 'error'
                ], 404);
            }

            // Check for active shift
            $today = Carbon::now()->format('Y-m-d');
            $currentShift = CashierReport::where('cashier_id', Auth::id())
                ->whereDate('work_date', $today)
                ->whereNull('shift_end')
                ->first();

            if (!$currentShift) {
                return response()->json([
                    'message' => 'Tidak ada shift aktif. Silakan mulai shift terlebih dahulu.',
                    'status' => 'error',
                    'needShift' => true
                ], 400);
            }

            $currentTime = now();
            $newShutdownTime = null;
            $packageName = 'Open Billing';
            $packageTime = null;
            $totalPrice = 0;

            if (!$request->is_open) {
                $package = BillingPackage::find($request->package_id);
                if (!$package) {
                    return response()->json([
                        'message' => 'Paket tidak ditemukan',
                        'status' => 'error'
                    ], 404);
                }
                
                $packageTime = ($package->duration_hours * 60) + $package->duration_minutes;
                $newShutdownTime = $currentTime->copy()->addMinutes($packageTime);
                $packageName = $package->package_name;
                $totalPrice = $package->total_price;
            }

            DB::beginTransaction();
            try {
                // Create transaction report
                $transaction = TransactionReport::create([
                    'device_id' => $device->id,
                    'user_id' => Auth::id(),
                    'package_name' => $packageName,
                    'package_time' => $packageTime,
                    'start_time' => $currentTime,
                    'end_time' => $newShutdownTime,
                    'total_price' => $totalPrice,
                    'status' => 'active'
                ]);

                // Update device status and last_used_at
                $device->status = 'Berjalan';
                $device->package = $packageName;
                $device->shutdown_time = $newShutdownTime;
                $device->last_used_at = $currentTime;
                $device->save();

                // Update shift totals
                $currentShift->increment('total_transactions');
                $currentShift->increment('total_revenue', $totalPrice);

                DB::commit();

                return response()->json([
                    'message' => 'Billing berhasil dimulai',
                    'status' => $device->status,
                    'start_time' => $currentTime->format('Y-m-d H:i:s'),
                    'shutdown_time' => $newShutdownTime ? $newShutdownTime->format('Y-m-d H:i:s') : null
                ]);

            } catch (\Exception $e) {
                DB::rollback();
                throw $e;
            }
            
        } catch (\Exception $e) {
            \Log::error('Start Billing Error:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'message' => 'Terjadi kesalahan saat memulai billing',
                'status' => 'error'
            ], 500);
        }
    }

    public function updateDeviceStatus(Request $request)
    {
        try {
            $validated = $request->validate([
                'device_id' => 'required|exists:devices,id',
                'status' => 'required|string'
            ]);

            $device = Device::find($request->device_id);
            
            if (!$device) {
                return response()->json([
                    'message' => 'Device tidak ditemukan',
                    'status' => 'error'
                ], 404);
            }

            // Update status but keep shutdown_time and package
            $device->status = $request->status;
            $device->save();

            return response()->json([
                'message' => 'Status berhasil diupdate',
                'status' => 'success',
                'device_status' => $device->status
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Update Status Error:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'message' => 'Terjadi kesalahan saat mengupdate status',
                'status' => 'error'
            ], 500);
        }
    }

    private function calculateOpenBillingPrice($minutes)
    {
        // Get billing settings from database
        $billingOpen = DB::table('billing_open')->first();
        if (!$billingOpen) {
            \Log::error('Billing Open settings not found in database');
            return 0;
        }

        // Calculate full hours and remaining minutes
        $hours = floor($minutes / 60);
        $remainingMinutes = $minutes % 60;
        
        // Calculate price for full hours
        $totalPrice = $hours * $billingOpen->price_per_hour;

        // Always charge at least one block, even if time is less than minute_count
        if ($remainingMinutes > 0 || $hours == 0) {
            $blocks = max(1, ceil($remainingMinutes / $billingOpen->minute_count));
            $minutePrice = $blocks * $billingOpen->price_per_minute;
            $totalPrice += $minutePrice;
        }

        \Log::info('Price breakdown:', [
            'total_minutes' => $minutes,
            'hours' => $hours,
            'remaining_minutes' => $remainingMinutes,
            'minute_blocks' => $blocks ?? 0,
            'hourly_price' => $billingOpen->price_per_hour,
            'minute_block_price' => $billingOpen->price_per_minute,
            'minute_block_size' => $billingOpen->minute_count,
            'total_price' => $totalPrice
        ]);

        return round($totalPrice); // Round to nearest integer
    }

    public function finishBilling(Request $request)
    {
        try {
            $validated = $request->validate([
                'device_id' => 'required|exists:devices,id'
            ]);

            $device = Device::find($request->device_id);
            
            if (!$device) {
                return response()->json([
                    'message' => 'Device tidak ditemukan',
                    'status' => 'error'
                ], 404);
            }

            $now = now();

            DB::beginTransaction();
            try {
                // Find the latest unfinished transaction for this device
                $latestTransaction = TransactionReport::where('device_id', $device->id)
                    ->where(function($query) {
                        $query->whereNull('end_time')
                              ->orWhereRaw('end_time > NOW()');
                    })
                    ->latest()
                    ->first();

                if ($latestTransaction) {
                    \Log::info('Found transaction to finish:', [
                        'transaction_id' => $latestTransaction->id,
                        'start_time' => $latestTransaction->start_time,
                        'package_name' => $latestTransaction->package_name
                    ]);

                    // For Open Billing, calculate the total minutes run and price
                    if ($latestTransaction->package_name === 'Open Billing') {
                        $startTime = \Carbon\Carbon::parse($latestTransaction->start_time);
                        $packageTime = $startTime->diffInMinutes($now);
                        
                        \Log::info('Calculating Open Billing duration:', [
                            'start_time' => $startTime->format('Y-m-d H:i:s'),
                            'end_time' => $now->format('Y-m-d H:i:s'),
                            'minutes_run' => $packageTime
                        ]);

                        $latestTransaction->package_time = $packageTime;
                        
                        // Calculate and set the total price
                        $totalPrice = $this->calculateOpenBillingPrice($packageTime);
                        $latestTransaction->total_price = $totalPrice;

                        \Log::info('Open Billing price calculated:', [
                            'minutes_run' => $packageTime,
                            'total_price' => $totalPrice
                        ]);
                    }
                    
                    $latestTransaction->end_time = $now;
                    $latestTransaction->save();
                } else {
                    \Log::warning('No active transaction found for device:', [
                        'device_id' => $device->id
                    ]);
                }

                // Reset device status and clear billing info
                $device->status = 'Tersedia';
                $device->package = null;
                $device->shutdown_time = null;
                $device->last_used_at = $now;
                $device->save();

                DB::commit();

                return response()->json([
                    'message' => 'Billing berhasil diselesaikan',
                    'status' => 'success'
                ]);
            } catch (\Exception $e) {
                DB::rollback();
                throw $e;
            }
            
        } catch (\Exception $e) {
            \Log::error('Finish Billing Error:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'message' => 'Terjadi kesalahan saat menyelesaikan billing',
                'status' => 'error'
            ], 500);
        }
    }

    public function restartBilling(Request $request)
    {
        try {
            $validated = $request->validate([
                'device_id' => 'required|exists:devices,id'
            ]);

            $device = Device::find($request->device_id);
            
            if (!$device) {
                return response()->json([
                    'message' => 'Device tidak ditemukan',
                    'status' => 'error'
                ], 404);
            }

            // Update device status to Berjalan
            $device->status = 'Berjalan';
            $device->save();

            return response()->json([
                'message' => 'Device berhasil direstart',
                'status' => 'success',
                'device_status' => $device->status
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Restart Billing Error:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'message' => 'Terjadi kesalahan saat merestart device',
                'status' => 'error'
            ], 500);
        }
    }
}
