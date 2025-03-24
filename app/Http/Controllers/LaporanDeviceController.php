<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\TransactionReport;
use App\Models\KendalaReport;
use App\Models\Device;
use Illuminate\Http\Request;

class LaporanDeviceController extends Controller
{
    public function index()
    {
        // Get all transactions
        $transactions = TransactionReport::with(['device', 'user'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $totalMinutes = TransactionReport::sum('package_time');
        
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

        $summary = [
            'total_kendala' => KendalaReport::count(),
            'total_waktu_pakai' => $formattedWaktuPakai,
            'total_booking' => TransactionReport::count(),
            'total_pendapatan' => TransactionReport::sum('total_price'),
        ];

        // Get all devices
        $devices = Device::orderBy('name')->get();

        return view('admin.laporanDevice', compact(
            'transactions',
            'summary',
            'devices'
        ));
    }
}
