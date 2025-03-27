<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\TransactionReport;
use App\Models\KendalaReport;
use App\Models\Device;
use Carbon\Carbon;
use Illuminate\Http\Request;
use PDF;

class LaporanDeviceController extends Controller
{
    public function index(Request $request)
    {
        $devices = Device::orderByRaw('LENGTH(name), name')->get();
        $query = TransactionReport::with(['device', 'user']);

        if ($request->has('device_id') && !empty($request->device_id)) {
            $query->where('device_id', $request->device_id);
        }

        if ($request->has('start_date') && $request->has('end_date')) {
            $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
        }

        $summary = $this->getSummary($query);
        $transactions = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.laporanDevice', compact('transactions', 'summary', 'devices'));
    }

    public function filterByDate(Request $request)
    {
        $query = TransactionReport::with(['device', 'user']);

        if ($request->start_date) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        if ($request->end_date) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }
        if ($request->device_id) {
            $query->where('device_id', $request->device_id);
        }

        $summaryQuery = clone $query;
        $summary = $this->getSummary($summaryQuery);
        $transactions = $query->orderBy('created_at', 'desc')->paginate(10);

        return response()->json([
            'html' => view('Admin.partials.device-table', compact('transactions'))->render(),
            'summary' => $summary,
            'pagination' => $transactions->appends($request->all())->links()->render(),
            'first_item' => $transactions->firstItem() ?? 0,
            'last_item' => $transactions->lastItem() ?? 0,
            'total' => $transactions->total()
        ]);
    }

    public function filterByDevice(Request $request)
    {
        $query = TransactionReport::with(['device', 'user']);

        if ($request->device_id) {
            $query->where('device_id', $request->device_id);
        }
        if ($request->start_date) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        if ($request->end_date) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        $summary = $this->getSummary($query);
        $transactions = $query->orderBy('created_at', 'desc')->paginate(10);

        return response()->json([
            'html' => view('Admin.partials.device-table', compact('transactions'))->render(),
            'summary' => $summary,
            'pagination' => $transactions->links()->render(),
            'first_item' => $transactions->firstItem() ?? 0,
            'last_item' => $transactions->lastItem() ?? 0,
            'total' => $transactions->total()
        ]);
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        
        $filteredTransactions = TransactionReport::with(['device', 'user'])
            ->where(function ($q) use ($query) {
                $q->whereHas('device', function ($subQuery) use ($query) {
                    $subQuery->where('name', 'LIKE', "%{$query}%");
                })
                ->orWhereHas('user', function ($subQuery) use ($query) {
                    $subQuery->where('name', 'LIKE', "%{$query}%");
                })
                ->orWhere('total_price', 'LIKE', "%{$query}%")
                ->orWhere('package_name', 'LIKE', "%{$query}%")
                ->orWhere('package_time', 'LIKE', "%{$query}%")
                ->orWhere('original_price', 'LIKE', "%{$query}%")
                ->orWhere('discount_amount', 'LIKE', "%{$query}%");
            });

        $summary = $this->getSummary($filteredTransactions);
        $transactions = $filteredTransactions->paginate(10);

        return response()->json([
            'html' => view('Admin.partials.device-table', compact('transactions'))->render(),
            'summary' => $summary,
            'pagination' => $transactions->appends(['query' => $query])->links()->render(),
            'first_item' => $transactions->firstItem() ?? 0,
            'last_item' => $transactions->lastItem() ?? 0,
            'total' => $transactions->total()
        ]);
    }

    public function downloadPdf(Request $request)
    {
        $query = TransactionReport::with(['device', 'user'])->orderBy('created_at', 'desc');

        if ($request->download_type === 'filtered') {
            if ($request->start_date) {
                $query->whereDate('created_at', '>=', $request->start_date);
            }
            if ($request->end_date) {
                $query->whereDate('created_at', '<=', $request->end_date);
            }
            if ($request->device_id) {
                $query->where('device_id', $request->device_id);
            }
        }

        $transactions = $query->get();
        $summary = $this->getSummary($query);

        // Get device name if filtered by specific device
        $deviceName = '';
        if ($request->device_id) {
            $device = Device::find($request->device_id);
            $deviceName = $device ? $device->name : '';
        }

        $data = [
            'title' => 'Laporan Device',
            'transactions' => $transactions,
            'summary' => $summary,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'device_name' => $deviceName,
            'tanggalDownload' => Carbon::now()->isoFormat('dddd, D MMMM Y HH:mm')
        ];

        $filename = 'laporan_device_' . Carbon::now()->format('YmdHis');
        if ($request->download_type === 'filtered') {
            if ($request->device_id) {
                $filename .= '_' . str_replace(' ', '_', strtolower($deviceName));
            }
            if ($request->start_date) {
                $filename .= '_' . $request->start_date;
            }
            if ($request->end_date) {
                $filename .= '_' . $request->end_date;
            }
        }
        $filename .= '.pdf';

        $pdf = PDF::loadView('admin.pdf.laporan-device', $data);
        $pdf->setPaper('a4', 'landscape');

        return $pdf->download($filename);
    }

    private function getSummary($query)
    {
        $totalMinutes = $query->sum('package_time');
        
        $years = floor($totalMinutes / (525600)); 
        $remainingMinutes = $totalMinutes % 525600;
        
        $months = floor($remainingMinutes / (43800));
        $remainingMinutes = $remainingMinutes % 43800;
        
        $days = floor($remainingMinutes / 1440); 
        $remainingMinutes = $remainingMinutes % 1440;
        
        $hours = floor($remainingMinutes / 60);
        $minutes = $remainingMinutes % 60;

        $waktuPakai = [];
        if ($years > 0) $waktuPakai[] = $years . ' Tahun';
        if ($months > 0) $waktuPakai[] = $months . ' Bulan';
        if ($days > 0) $waktuPakai[] = $days . ' Hari';
        if ($hours > 0) $waktuPakai[] = $hours . ' Jam';
        if ($minutes > 0) $waktuPakai[] = $minutes . ' Menit';
        
        $formattedWaktuPakai = !empty($waktuPakai) ? implode(' ', $waktuPakai) : '0 Menit';

        return [
            'total_kendala' => KendalaReport::when($query->getQuery()->wheres, function($q) use ($query) {
                $q->whereIn('device_id', $query->pluck('device_id'));
            })->count(),
            'total_waktu_pakai' => $formattedWaktuPakai,
            'total_booking' => $query->count(),
            'total_pendapatan' => $query->sum('total_price'),
        ];
    }
}
