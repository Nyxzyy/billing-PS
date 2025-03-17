<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\KendalaReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class KendalaController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'device_id' => 'required|exists:devices,id',
            'issue' => 'required|string'
        ]);

        try {
            $device = Device::findOrFail($request->device_id);
            
            // Start database transaction
            \DB::beginTransaction();

            // Create kendala report
            KendalaReport::create([
                'cashier_id' => Auth::id(),
                'device_id' => $request->device_id,
                'issue' => $request->issue,
                'time' => Carbon::now()->format('H:i:s'),
                'date' => Carbon::now()->format('Y-m-d'),
                'status' => 'Pending'
            ]);

            // Update device status to maintenance
            $device->update([
                'status' => 'maintenance'
            ]);

            \DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Kendala berhasil dilaporkan'
            ]);

        } catch (\Exception $e) {
            \DB::rollback();
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getLatest($deviceId)
    {
        try {
            $kendala = KendalaReport::where('device_id', $deviceId)
                ->where('status', 'Pending')
                ->latest()
                ->first();

            if (!$kendala) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Tidak ada kendala yang ditemukan'
                ], 404);
            }

            return response()->json([
                'status' => 'success',
                'kendala' => $kendala
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function resolve(Request $request)
    {
        $request->validate([
            'device_id' => 'required|exists:devices,id'
        ]);

        try {
            $device = Device::findOrFail($request->device_id);
            
            // Start database transaction
            \DB::beginTransaction();

            // Update kendala report status
            KendalaReport::where('device_id', $request->device_id)
                ->where('status', 'Pending')
                ->update(['status' => 'Selesai']);

            // Update device status to inactive (available)
            $device->update([
                'status' => 'Tersedia'
            ]);

            \DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Kendala berhasil diselesaikan'
            ]);

        } catch (\Exception $e) {
            \DB::rollback();
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}
