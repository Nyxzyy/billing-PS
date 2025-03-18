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
            $currentShift = CashierReport::where('cashier_id', Auth::id())
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
            $currentTime = Carbon::now();
            
            if ($device->shutdown_time) {
                $shutdownTime = Carbon::parse($device->shutdown_time);
                
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
                    'total_price' => $package->total_price
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
                    'status' => 'Berjalan',
                    'transaction_id' => $transaction->id,
                    'shutdown_time' => $newShutdownTime->toIso8601String()
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
            $currentShift = CashierReport::where('cashier_id', Auth::id())
                ->whereNull('shift_end')
                ->first();

            if (!$currentShift) {
                return response()->json([
                    'message' => 'Tidak ada shift aktif. Silakan mulai shift terlebih dahulu.',
                    'status' => 'error',
                    'needShift' => true
                ], 400);
            }

            $currentTime = Carbon::now();
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
            } else {
                // Check if billing_open data exists
                $billingOpen = BillingOpen::first();
                if (!$billingOpen) {
                    return response()->json([
                        'message' => 'Harga Open Billing belum diatur. Silakan atur harga terlebih dahulu.',
                        'status' => 'error'
                    ], 400);
                }
            }

            DB::beginTransaction();
            try {
                // Create transaction record
                $transaction = TransactionReport::create([
                    'device_id' => $device->id,
                    'user_id' => Auth::id(),
                    'package_name' => $packageName,
                    'package_time' => $packageTime,
                    'start_time' => $currentTime,
                    'end_time' => $newShutdownTime,
                    'total_price' => $totalPrice
                ]);

                // Update device status
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
                    'status' => 'Berjalan',
                    'transaction_id' => $transaction->id,
                    'shutdown_time' => $newShutdownTime ? $newShutdownTime->toIso8601String() : null
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

            // Get the latest transaction for this device
            $transaction = TransactionReport::where('device_id', $device->id)
                ->whereNull('end_time')
                ->latest()
                ->first();

            if ($transaction) {
                // Calculate duration and price for open billing
                $startTime = Carbon::parse($transaction->start_time);
                $endTime = Carbon::now();
                
                // Pastikan endTime selalu lebih besar dari startTime
                if ($endTime->lt($startTime)) {
                    $endTime = $startTime->copy();
                }
                
                // Hitung durasi dalam menit (absolute value)
                $duration = abs($startTime->diffInMinutes($endTime));
                
                // If this is an open billing, calculate the price
                if ($transaction->package_name === 'Open Billing') {
                    // Get the billing settings
                    $billingOpen = BillingOpen::first();
                    if (!$billingOpen) {
                        return response()->json([
                            'message' => 'Harga Open Billing belum diatur. Silakan hubungi admin untuk mengatur harga terlebih dahulu.',
                            'status' => 'error'
                        ], 400);
                    }

                    // Calculate total price based on duration
                    $totalPrice = 0;
                    
                    // Jika durasi 0 menit (kurang dari 1 menit), tetap hitung sebagai 1 menit
                    if ($duration == 0) {
                        $duration = 1;
                    }
                    
                    // If duration is less than or equal to 60 minutes
                    if ($duration <= 60) {
                        // Hitung berapa blok yang digunakan, minimal 1 blok
                        $blocks = max(1, ceil($duration / $billingOpen->minute_count));
                        $totalPrice = $blocks * $billingOpen->price_per_minute;
                    } else {
                        // Calculate full hours
                        $fullHours = floor($duration / 60);
                        $totalPrice += $fullHours * $billingOpen->price_per_hour;
                        
                        // Calculate remaining minutes
                        $remainingMinutes = $duration % 60;
                        if ($remainingMinutes > 0) {
                            // Hitung berapa blok yang digunakan untuk sisa menit, minimal 1 blok
                            $blocks = max(1, ceil($remainingMinutes / $billingOpen->minute_count));
                            $totalPrice += $blocks * $billingOpen->price_per_minute;
                        }
                    }

                    DB::beginTransaction();
                    try {
                        // Update transaction with final details
                        $transaction->package_time = $duration;
                        $transaction->end_time = $endTime;
                        $transaction->total_price = $totalPrice;
                        $transaction->save();

                        // Get shift yang memulai billing ini
                        $startShift = CashierReport::where('cashier_id', $transaction->user_id)
                            ->where('shift_start', '<=', $transaction->start_time)
                            ->where(function($query) use ($transaction) {
                                $query->where('shift_end', '>=', $transaction->start_time)
                                    ->orWhereNull('shift_end');
                            })
                            ->first();

                        // Jika shift awal ditemukan dan berbeda dengan shift saat ini
                        if ($startShift) {
                            $startShift->increment('total_revenue', $totalPrice);
                        } else {
                            // Jika shift awal tidak ditemukan, tambahkan ke shift yang aktif
                            $currentShift = CashierReport::where('cashier_id', Auth::id())
                                ->whereNull('shift_end')
                                ->first();

                            if ($currentShift) {
                                $currentShift->increment('total_revenue', $totalPrice);
                            }
                        }

                        DB::commit();
                    } catch (\Exception $e) {
                        DB::rollback();
                        throw $e;
                    }
                }
                // For regular billing, just update the end time
                else {
                    $transaction->end_time = $endTime;
                    $transaction->save();
                }
            }

            // Update device status
            $device->status = 'Tersedia';
            $device->package = null;
            $device->shutdown_time = null;
            $device->last_used_at = null;
            $device->save();

            return response()->json([
                'message' => 'Billing berhasil diselesaikan',
                'status' => 'success',
                'transaction' => $transaction ? [
                    'duration' => $duration ?? null,
                    'total_price' => $transaction->total_price,
                    'start_time' => $transaction->start_time,
                    'end_time' => $transaction->end_time,
                    'id' => $transaction->id
                ] : null
            ]);

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

    public function updateDeviceStatus(Request $request)
    {
        try {
            $validated = $request->validate([
                'device_id' => 'required|exists:devices,id',
                'status' => 'required|string|in:Tersedia,Berjalan,Pending,Selesai,Maintenance',
                'server_time' => 'nullable|date'
            ]);

            $device = Device::find($request->device_id);
            if (!$device) {
                return response()->json([
                    'message' => 'Device tidak ditemukan',
                    'status' => 'error'
                ], 404);
            }

            // If changing status to Berjalan from Pending
            if ($request->status === 'Berjalan' && $device->status === 'Pending') {
                // Get latest transaction to check if it's Open Billing
                $transaction = TransactionReport::where('device_id', $device->id)
                    ->whereNull('end_time')
                    ->latest()
                    ->first();

                // For regular billing, check shutdown_time
                if (!$transaction || $transaction->package_name !== 'Open Billing') {
                    if (!$device->shutdown_time) {
                        return response()->json([
                            'message' => 'Tidak dapat melanjutkan billing, waktu telah habis',
                            'status' => 'error'
                        ], 400);
                    }

                    $now = Carbon::now();
                    $shutdownTime = Carbon::parse($device->shutdown_time);
                    
                    // If billing time has expired, don't allow restart
                    if ($now->gt($shutdownTime)) {
                        return response()->json([
                            'message' => 'Tidak dapat melanjutkan billing, waktu telah habis',
                            'status' => 'error'
                        ], 400);
                    }
                }

                $device->status = 'Berjalan';
                $device->save();

                return response()->json([
                    'message' => 'Status device berhasil diperbarui ke Berjalan',
                    'status' => 'success',
                    'device' => [
                        'id' => $device->id,
                        'status' => $device->status,
                        'package' => $device->package,
                        'shutdown_time' => $device->shutdown_time
                    ]
                ]);
            }

            // Update device status
            $device->status = $request->status;
            
            // Clear billing info if status is Tersedia
            if ($request->status === 'Tersedia') {
                $device->package = null;
                $device->shutdown_time = null;
                $device->last_used_at = null;
            }
            
            $device->save();

            \Log::info('Device status updated:', [
                'device_id' => $device->id,
                'old_status' => $device->getOriginal('status'),
                'new_status' => $request->status,
                'shutdown_time' => $device->shutdown_time,
                'server_time' => $request->server_time
            ]);

            return response()->json([
                'message' => 'Status device berhasil diperbarui',
                'status' => 'success',
                'device' => [
                    'id' => $device->id,
                    'status' => $device->status,
                    'package' => $device->package,
                    'shutdown_time' => $device->shutdown_time
                ]
            ]);

        } catch (\Exception $e) {
            \Log::error('Update Device Status Error:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'message' => 'Terjadi kesalahan saat memperbarui status device',
                'status' => 'error'
            ], 500);
        }
    }

    public function getServerTime()
    {
        return response()->json([
            'timestamp' => Carbon::now()->toIso8601String(),
            'timezone' => config('app.timezone')
        ]);
    }
}
