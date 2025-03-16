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
        $today = Carbon::now()->format('Y-m-d');
        $hasActiveShift = CashierReport::where('cashier_id', Auth::id())
            ->whereDate('work_date', $today)
            ->whereNull('shift_end')
            ->exists();

        return response()->json([
            'hasActiveShift' => $hasActiveShift
        ]);
    }

    public function startShift()
    {
        try {
            $now = Carbon::now();
            $today = $now->format('Y-m-d');

            // Check if already has active shift
            $existingShift = CashierReport::where('cashier_id', Auth::id())
                ->whereDate('work_date', $today)
                ->whereNull('shift_end')
                ->first();

            if ($existingShift) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Anda sudah memulai shift hari ini'
                ], 400);
            }

            // Create new shift
            CashierReport::create([
                'cashier_id' => Auth::id(),
                'shift_start' => $now,
                'work_date' => $today,
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
            $today = Carbon::now()->format('Y-m-d');
            
            $currentShift = CashierReport::where('cashier_id', Auth::id())
                ->whereDate('work_date', $today)
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
