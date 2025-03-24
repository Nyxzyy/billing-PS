<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\CashierReport;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use PDF;

class LaporanKasirController extends Controller
{
    public function index(Request $request)
    {
        $cashiers = User::whereHas('role', function($query) {
            $query->where('name', 'Kasir');
        })->get();

        $query = CashierReport::with('cashier')
            ->select('cashier_reports.*');

        if ($request->has('cashier_id') && !empty($request->cashier_id)) {
            $query->where('cashier_id', $request->cashier_id);
        }

        if ($request->has('start_date') && $request->has('end_date')) {
            $query->whereBetween('work_date', [$request->start_date, $request->end_date]);
        }

        $summary = [
            'total_work_hours' => $query->sum('total_work_hours'),
            'total_transactions' => $query->sum('total_transactions'),
            'total_revenue' => $query->sum('total_revenue'),
        ];

        $reports = $query->orderBy('work_date', 'desc')
            ->paginate(10);

        return view('admin.laporanKasir', compact('reports', 'summary', 'cashiers'));
    }

    public function filterByDate(Request $request)
    {
        $startDate = $request->start_date;
        $endDate = $request->end_date;

        $query = CashierReport::with('cashier');

        if ($startDate) {
            $query->whereDate('work_date', '>=', $startDate);
        }

        if ($endDate) {
            $query->whereDate('work_date', '<=', $endDate);
        }

        $summary = [
            'total_work_hours' => $query->sum('total_work_hours'),
            'total_transactions' => $query->sum('total_transactions'),
            'total_revenue' => $query->sum('total_revenue'),
        ];

        $reports = $query->orderBy('work_date', 'desc')->paginate(10);

        return response()->json([
            'html' => view('Admin.partials.kasir-table', compact('reports'))->render(),
            'summary' => $summary,
            'pagination' => (string) $reports->appends(['start_date' => $startDate, 'end_date' => $endDate])->links(),
            'first_item' => $reports->firstItem() ?? 0,
            'last_item' => $reports->lastItem() ?? 0,
            'total' => $reports->total()
        ]);
    }

    public function filterByCashier(Request $request)
    {
        $cashierId = $request->cashier_id;
        
        $query = CashierReport::with('cashier');

        if ($cashierId) {
            $query->where('cashier_id', $cashierId);
        }

        // Apply date filters if they exist
        if ($request->start_date) {
            $query->whereDate('work_date', '>=', $request->start_date);
        }
        if ($request->end_date) {
            $query->whereDate('work_date', '<=', $request->end_date);
        }

        $reports = $query->orderBy('work_date', 'desc')->paginate(10);

        $summary = [
            'total_work_hours' => $query->sum('total_work_hours'),
            'total_transactions' => $query->sum('total_transactions'),
            'total_revenue' => $query->sum('total_revenue'),
        ];

        return response()->json([
            'html' => view('Admin.partials.kasir-table', compact('reports'))->render(),
            'summary' => $summary,
            'pagination' => $reports->links()->render(),
            'first_item' => $reports->firstItem() ?? 0,
            'last_item' => $reports->lastItem() ?? 0,
            'total' => $reports->total()
        ]);
    }

    public function search(Request $request)
    {
        $query = $request->input('query');

        $filteredReports = CashierReport::with('cashier')
            ->where(function ($q) use ($query) {
                $q->whereHas('cashier', function ($subQuery) use ($query) {
                    $subQuery->where('name', 'LIKE', "%{$query}%");
                })
                ->orWhere('work_date', 'LIKE', "%{$query}%")
                ->orWhere('total_work_hours', 'LIKE', "%{$query}%")
                ->orWhere('total_transactions', 'LIKE', "%{$query}%")
                ->orWhere('total_revenue', 'LIKE', "%{$query}%");
            });

        $reports = $filteredReports->paginate(10);
        
        // Calculate summary for filtered data
        $summary = [
            'total_work_hours' => $filteredReports->sum('total_work_hours'),
            'total_transactions' => $filteredReports->sum('total_transactions'),
            'total_revenue' => $filteredReports->sum('total_revenue'),
        ];

        return response()->json([
            'html' => view('Admin.partials.kasir-table', compact('reports'))->render(),
            'summary' => $summary,
            'pagination' => $reports->links()->render(),
            'first_item' => $reports->firstItem() ?? 0,
            'last_item' => $reports->lastItem() ?? 0,
            'total' => $reports->total()
        ]);
    }

    public function downloadPdf(Request $request)
    {
        $query = CashierReport::with('cashier')->orderBy('work_date', 'desc');

        // Apply date filters if download_type is 'filtered'
        if ($request->download_type === 'filtered') {
            if ($request->start_date) {
                $query->whereDate('work_date', '>=', $request->start_date);
            }
            if ($request->end_date) {
                $query->whereDate('work_date', '<=', $request->end_date);
            }
        }

        $reports = $query->get();
        
        $summary = [
            'total_work_hours' => $reports->sum('total_work_hours'),
            'total_transactions' => $reports->sum('total_transactions'),
            'total_revenue' => $reports->sum('total_revenue'),
        ];

        $data = [
            'title' => 'Laporan Kasir',
            'reports' => $reports,
            'summary' => $summary,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'tanggalDownload' => Carbon::now()->isoFormat('dddd, D MMMM Y HH:mm')
        ];

        $filename = 'laporan_kasir_' . Carbon::now()->format('YmdHis');
        if ($request->download_type === 'filtered') {
            $filename .= '_' . $request->start_date . '_' . $request->end_date;
        }
        $filename .= '.pdf';

        $pdf = PDF::loadView('admin.pdf.laporan-kasir', $data);
        $pdf->setPaper('a4', 'landscape');

        return $pdf->download($filename);
    }
}
