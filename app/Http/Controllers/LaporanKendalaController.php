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
        $kendalaReports = KendalaReport::with(['cashier', 'device'])->paginate(10);
        $totalKendala = KendalaReport::count();
    
        return view('admin.laporanKendala', compact('kendalaReports', 'totalKendala'));
    }    

    public function downloadPdf(Request $request)
    {
        $query = KendalaReport::with(['cashier', 'device'])->orderBy('date', 'desc')->orderBy('time', 'desc');
    
        // Terapkan filter tanggal jika download_type = 'filtered'
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