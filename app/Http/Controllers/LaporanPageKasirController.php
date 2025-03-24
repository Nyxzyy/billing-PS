<?php

namespace App\Http\Controllers;

use App\Models\TransactionReport;
use App\Models\CashierReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class LaporanPageKasirController extends Controller
{
    public function index()
    {
        // Hapus filter berdasarkan today
        $currentShift = CashierReport::where('cashier_id', Auth::id())
            ->whereNull('shift_end')
            ->first();

        $transactions = collect([]);
        $totalRevenue = 0;
        
        if ($currentShift) {
            // Ubah query untuk mengambil transaksi berdasarkan shift_start saja
            $transactions = TransactionReport::with(['device', 'user'])
                ->where('user_id', Auth::id())
                ->where('created_at', '>=', $currentShift->shift_start)
                ->orderBy('created_at', 'desc')
                ->get()
                ->map(function ($transaction) {
                    return [
                        'id' => $transaction->id,
                        'device_name' => $transaction->device->name,
                        'package_name' => $transaction->package_name,
                        'package_time' => $transaction->package_time,
                        'start_time' => Carbon::parse($transaction->start_time)->format('H:i'),
                        'end_time' => $transaction->end_time ? Carbon::parse($transaction->end_time)->format('H:i') : '-',
                        'original_price' => $transaction->original_price,
                        'discount_amount' => $transaction->discount_amount,
                        'total_price' => $transaction->total_price
                    ];
                });

            $totalRevenue = $transactions->sum('total_price');

            // Update shift report
            $currentShift->update([
                'total_transactions' => $transactions->count(),
                'total_revenue' => $totalRevenue,
                'total_work_hours' => Carbon::parse($currentShift->shift_start)->diffInHours(now())
            ]);
        }

        return view('Kasir.laporan', [
            'transactions' => $transactions,
            'currentShift' => $currentShift,
            'totalRevenue' => $totalRevenue
        ]);
    }

    public function printReceipt($transactionId)
    {
        $transaction = TransactionReport::with(['device', 'user'])->findOrFail($transactionId);
        
        if ($transaction->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        // Tambahkan debug logging
        \Log::info('Transaction Data:', [
            'package_name' => $transaction->package_name,
            'original_price' => $transaction->original_price,
            'discount_amount' => $transaction->discount_amount,
            'total_price' => $transaction->total_price
        ]);

        return view('Kasir.receipt', [
            'transaction' => [
                'id' => $transaction->id,
                'device_name' => $transaction->device->name,
                'package_name' => $transaction->package_name,
                'package_time' => $transaction->package_time,
                'start_time' => Carbon::parse($transaction->start_time)->format('H:i'),
                'end_time' => $transaction->end_time ? Carbon::parse($transaction->end_time)->format('H:i') : '-',
                'total_price' => $transaction->total_price,
                'original_price' => $transaction->original_price ?? $transaction->total_price, // Fallback ke total_price
                'discount_amount' => $transaction->discount_amount ?? 0,
                'cashier_name' => $transaction->user->name,
                'date' => Carbon::parse($transaction->created_at)->format('d/m/Y')
            ]
        ]);
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
