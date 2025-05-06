<?php

namespace App\Http\Controllers;

use App\Models\KendalaReport;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use PDF;

class LaporanKendalaController extends Controller
{
    public function index(Request $request)
    {
        $query = KendalaReport::with(['cashier', 'device']);

        if ($request->has('start_date') && $request->has('end_date')) {
            $query->whereBetween('date', [$request->start_date, $request->end_date]);
        }

        $kendalaReports = $query->paginate(10);
        $totalKendala = $query->count();

        return view('admin.laporanKendala', compact('kendalaReports', 'totalKendala'));
    }

    public function filterByDate(Request $request)
    {
        $startDate = $request->start_date;
        $endDate = $request->end_date;

        $query = KendalaReport::with(['cashier', 'device']);

        if ($startDate) {
            $query->whereDate('date', '>=', $startDate);
        }

        if ($endDate) {
            $query->whereDate('date', '<=', $endDate);
        }

        $totalKendala = $query->count();

        $kendalaReports = $query->paginate(10);

        return response()->json([
            'html' => view('admin.partials.kendala-table', compact('kendalaReports'))->render(),
            'total_kendala' => $totalKendala,
            'pagination' => (string) $kendalaReports->appends(['start_date' => $startDate, 'end_date' => $endDate])->links(),
            'first_item' => $kendalaReports->firstItem() ?? 0,
            'last_item' => $kendalaReports->lastItem() ?? 0,
            'total' => $totalKendala
        ]);
    }

    public function search(Request $request)
    {
        $query = KendalaReport::with(['cashier', 'device'])
            ->orderBy('date', 'desc');

        if ($request->get('query')) {
            $search = $request->get('query');
            $query->where(function($q) use ($search) {
                $q->whereHas('cashier', function($q) use ($search) {
                    $q->where('name', 'LIKE', "%{$search}%");
                })
                ->orWhereHas('device', function($q) use ($search) {
                    $q->where('name', 'LIKE', "%{$search}%");
                })
                ->orWhere('issue', 'LIKE', "%{$search}%")
                ->orWhere('time', 'LIKE', "%{$search}%")
                ->orWhere('date', 'LIKE', "%{$search}%")
                ->orWhere('status', 'LIKE', "%{$search}%");
            });
        }

        $kendalaReports = $query->paginate(10);
        $total = $query->count();

        if ($request->ajax()) {
            return response()->json([
                'html' => view('admin.partials.kendala-table', ['kendalaReports' => $kendalaReports])->render(),
                'pagination' => $kendalaReports->links()->render(),
                'first_item' => $kendalaReports->firstItem() ?? 0,
                'last_item' => $kendalaReports->lastItem() ?? 0,
                'total' => $total
            ]);
        }

        return view('admin.laporanKendala', compact('kendalaReports'));
    }

    public function downloadPdf(Request $request)
    {
        $query = KendalaReport::with(['cashier', 'device'])->orderBy('date', 'desc')->orderBy('time', 'desc');

        if ($request->download_type === 'filtered') {
            if ($request->start_date) {
                $query->whereDate('date', '>=', $request->start_date);
            }
            if ($request->end_date) {
                $query->whereDate('date', '<=', $request->end_date);
            }
        }

        $kendalaReports = $query->get();
        $totalKendala = $kendalaReports->count();
        $pendingCount = $kendalaReports->where('status', 'Pending')->count();
        $selesaiCount = $kendalaReports->where('status', 'Selesai')->count();

        $data = [
            'title' => 'Laporan Kendala',
            'kendalaReports' => $kendalaReports,
            'totalKendala' => $totalKendala,
            'pendingCount' => $pendingCount,
            'selesaiCount' => $selesaiCount,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'tanggalDownload' => Carbon::now()->isoFormat('dddd, D MMMM Y HH:mm')
        ];

        $filename = 'laporan_kendala_' . Carbon::now()->format('YmdHis');
        if ($request->download_type === 'filtered') {
            $filename .= '_' . $request->start_date . '_' . $request->end_date;
        }
        $filename .= '.pdf';

        $pdf = PDF::loadView('admin.pdf.laporan-kendala', $data);
        $pdf->setPaper('a4', 'landscape');

        return $pdf->download($filename);
    }
}
