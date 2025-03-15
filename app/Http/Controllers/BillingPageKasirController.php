<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Device;
use App\Models\BillingPackage;

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
            // Validate the request
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

            // Get the package
            $package = BillingPackage::find($request->package_id);
            if (!$package) {
                return response()->json([
                    'message' => 'Paket tidak ditemukan',
                    'status' => 'error'
                ], 404);
            }

            // Calculate additional minutes from the package
            $additionalMinutes = ($package->duration_hours * 60) + $package->duration_minutes;

            // Debug log before processing
            \Log::info('Before Processing:', [
                'Device ID' => $device->id,
                'Device Name' => $device->name,
                'Current Time' => now()->format('Y-m-d H:i:s'),
                'Current Shutdown Time' => $device->shutdown_time,
                'Package Duration' => "{$package->duration_hours}h {$package->duration_minutes}m",
                'Additional Minutes' => $additionalMinutes,
                'Is Adding' => $request->is_adding
            ]);

            // Get current shutdown time and add minutes
            $currentTime = now();
            
            if ($device->shutdown_time) {
                $shutdownTime = \Carbon\Carbon::parse($device->shutdown_time);
                
                // Jika ini adalah penambahan waktu dan shutdown time masih di masa depan
                if ($request->is_adding && $shutdownTime->isFuture()) {
                    \Log::info('Adding time to existing future shutdown time');
                    $newShutdownTime = $shutdownTime->copy()->addMinutes($additionalMinutes);
                } else {
                    // Jika shutdown time sudah lewat atau bukan penambahan
                    \Log::info('Starting new time from current moment');
                    $newShutdownTime = $currentTime->copy()->addMinutes($additionalMinutes);
                }
            } else {
                // Jika tidak ada shutdown time, mulai dari waktu sekarang
                \Log::info('No shutdown time set, using current time');
                $newShutdownTime = $currentTime->copy()->addMinutes($additionalMinutes);
            }

            // Debug log setelah kalkulasi
            \Log::info('Time Calculation Details:', [
                'Current Time' => $currentTime->format('Y-m-d H:i:s'),
                'Original Shutdown' => $device->shutdown_time,
                'Additional Minutes' => $additionalMinutes,
                'New Shutdown' => $newShutdownTime->format('Y-m-d H:i:s'),
                'Is Adding' => $request->is_adding,
                'Is Original Past?' => $device->shutdown_time ? \Carbon\Carbon::parse($device->shutdown_time)->isPast() : 'No original time'
            ]);

            // Update device shutdown time
            $originalShutdown = $device->shutdown_time;
            $device->shutdown_time = $newShutdownTime;
            $device->save();

            // Verify the update
            $device->refresh();
            \Log::info('Final Time Update:', [
                'Original Time' => $originalShutdown,
                'Added Minutes' => $additionalMinutes,
                'Final Time' => $device->shutdown_time,
                'Is Adding' => $request->is_adding
            ]);

            return response()->json([
                'message' => 'Billing berhasil ditambahkan',
                'status' => $device->status,
                'shutdown_time' => $newShutdownTime->format('Y-m-d H:i:s')
            ]);
            
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
            // Validate the request
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

            // Calculate shutdown time based on package
            $now = now();
            if (!$request->is_open && $request->package_id) {
                $package = BillingPackage::find($request->package_id);
                if ($package) {
                    $totalMinutes = ($package->duration_hours * 60) + $package->duration_minutes;
                    $shutdown_time = $now->copy()->addMinutes($totalMinutes);
                } else {
                    return response()->json([
                        'message' => 'Paket tidak ditemukan',
                        'status' => 'error'
                    ], 404);
                }
            } else {
                // For open packages, set shutdown_time to null
                $shutdown_time = null;
            }

            // Update device status and shutdown time
            $device->status = 'Berjalan';
            $device->shutdown_time = $shutdown_time;
            $device->last_used_at = $now;
            $device->save();

            return response()->json([
                'message' => 'Billing berhasil dimulai',
                'status' => $device->status,
                'shutdown_time' => $shutdown_time ? $shutdown_time->format('Y-m-d H:i:s') : null
            ]);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'Data yang dikirim tidak valid',
                'errors' => $e->errors(),
                'status' => 'error'
            ], 422);
        } catch (\Exception $e) {
            \Log::error('Billing Start Error: ' . $e->getMessage());
            return response()->json([
                'message' => 'Terjadi kesalahan saat memulai billing',
                'status' => 'error'
            ], 500);
        }
    }
}
