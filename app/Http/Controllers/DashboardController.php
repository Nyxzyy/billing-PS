<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\Device;

class DashboardController extends Controller
{
    public function index()
    {
        // Get device statistics
        $totalDevices = Device::count();
        $runningDevices = Device::where('status', 'Berjalan')->count();
        $availableDevices = Device::where('status', 'Tersedia')->count();
        $maintenanceDevices = Device::where('status', 'Maintenance')->count();
        $pendingDevices = Device::where('status', 'Pending')->count();

        return view('kasir.dashboard', [
            'today' => now()->translatedFormat('l, d F Y H:i'),
            'totalDevices' => $totalDevices,
            'runningDevices' => $runningDevices,
            'availableDevices' => $availableDevices,
            'maintenanceDevices' => $maintenanceDevices,
            'pendingDevices' => $pendingDevices
        ]);
    }

    public function getCurrentTime()
    {
        return response()->json([
            'time' => Carbon::now()->format('H:i:s'),
            'date' => Carbon::now()->isoFormat('dddd, D MMMM Y')
        ]);
    }
}
