<?php

namespace App\Http\Controllers;

use App\Models\CashierReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ShiftController extends Controller
{
    public function checkShiftStatus()
    {
        // Check for any active shift (tanpa batasan waktu)
        $activeShift = CashierReport::where('cashier_id', Auth::id())
            ->whereNull('shift_end')
            ->orderBy('shift_start', 'desc')
            ->first();

        // Jika ada shift aktif, periksa apakah ada transaksi yang masih berjalan
        if ($activeShift) {
            return response()->json([
                'hasActiveShift' => true,
                'shiftData' => [
                    'id' => $activeShift->id,
                    'start_time' => $activeShift->shift_start,
                    'end_time' => $activeShift->shift_end,
                    'total_transactions' => $activeShift->total_transactions,
                    'total_revenue' => $activeShift->total_revenue
                ]
            ]);
        }

        return response()->json([
            'hasActiveShift' => false
        ]);
    }

    public function startShift()
    {
        try {
            $now = Carbon::now();

            // Check if already has active shift
            $existingShift = CashierReport::where('cashier_id', Auth::id())
                ->whereNull('shift_end')
                ->first();

            if ($existingShift) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Anda sudah memulai shift'
                ], 400);
            }

            // Create new shift
            CashierReport::create([
                'cashier_id' => Auth::id(),
                'shift_start' => $now,
                'work_date' => $now->format('Y-m-d'),
                'total_transactions' => 0,
                'total_revenue' => 0,
                'total_work_hours' => 0
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Shift berhasil dimulai'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat memulai shift'
            ], 500);
        }
    }

    public function endShift()
    {
        try {
            $currentShift = CashierReport::where('cashier_id', Auth::id())
                ->whereNull('shift_end')
                ->first();

            if (!$currentShift) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Tidak ada shift aktif yang ditemukan'
                ], 400);
            }

            // Calculate final work hours
            $workHours = Carbon::parse($currentShift->shift_start)->diffInHours(now());
            
            $currentShift->update([
                'shift_end' => now(),
                'total_work_hours' => $workHours
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Shift berhasil diakhiri',
                'work_hours' => $workHours
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat mengakhiri shift'
            ], 500);
        }
    }
}
