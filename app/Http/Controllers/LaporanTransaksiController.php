<?php

namespace App\Http\Controllers;

use App\Models\TransactionReport;
use Illuminate\Http\Request;
use PDF;

class LaporanTransaksiController extends Controller
{
    public function index(Request $request)
    {
        $query = TransactionReport::with(['user', 'device'])->latest();

        // Apply date range filter
        if ($request->filled('filter_start_date')) {
            $query->whereDate('created_at', '>=', $request->filter_start_date);
        }
        if ($request->filled('filter_end_date')) {
            $query->whereDate('created_at', '<=', $request->filter_end_date);
        }

        // Existing search filter
        if ($request->has('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->whereHas('user', function($query) use ($searchTerm) {
                    $query->where('name', 'like', '%' . $searchTerm . '%');
                })
                ->orWhereHas('device', function($query) use ($searchTerm) {
                    $query->where('name', 'like', '%' . $searchTerm . '%');
                })
                ->orWhere('package_name', 'like', '%' . $searchTerm . '%')
                ->orWhere('total_price', 'like', '%' . $searchTerm . '%');
            });
        }

        // Get totals before pagination
        $totalRevenue = $query->sum('total_price');
        $totalTransactions = $query->count();

        // Get paginated data
        $transactions = $query->paginate(10);

        if ($request->ajax()) {
            return response()->json([
                'table' => view('admin.partials.transaction-table', compact('transactions'))->render(),
                'totalTransactions' => number_format($totalTransactions, 0, ',', '.'),
                'totalRevenue' => 'Rp ' . number_format($totalRevenue, 0, ',', '.')
            ]);
        }

        return view('admin.laporanTransaksi', compact('transactions', 'totalTransactions', 'totalRevenue'));
    }

    public function download(Request $request)
    {
        $query = TransactionReport::with(['user', 'device'])->latest();

        // Apply date filters if downloading filtered data
        if ($request->download_type === 'filtered') {
            if ($request->start_date) {
                $query->whereDate('created_at', '>=', $request->start_date);
            }
            if ($request->end_date) {
                $query->whereDate('created_at', '<=', $request->end_date);
            }
        }

        $transactions = $query->get();
        $totalTransactions = $transactions->count();
        $totalRevenue = $transactions->sum('total_price');

        $pdf = PDF::loadView('admin.pdf.laporan-transaksi', [
            'transactions' => $transactions,
            'totalTransactions' => $totalTransactions,
            'totalRevenue' => $totalRevenue,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date
        ]);
        
        $pdf->setPaper('a4', 'landscape');

        $filename = 'Laporan_Transaksi_Admin_' . now()->format('Ymd_His');
        if ($request->download_type === 'filtered') {
            $filename .= '_' . $request->start_date . '_' . $request->end_date;
        }
        $filename .= '.pdf';

        return $pdf->download($filename);
    }
}
