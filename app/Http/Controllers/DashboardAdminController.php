<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Device;
use App\Models\User;
use App\Models\TransactionReport;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardAdminController extends Controller
{
    public function index()
    {
        $totalDevices = Device::count();
        $usedDevices = Device::whereIn('status', ['Berjalan', 'Pending'])->count();
        $availableDevices = Device::where('status', 'Tersedia')->count();
        $maintenanceDevices = Device::where('status', 'Maintenance')->count();

        $totalCashiers = User::whereHas('role', function($query) {
            $query->where('name', 'kasir');
        })->count();

        // Get today's income with hourly breakdown
        $today = Carbon::today();
        $todayIncome = TransactionReport::whereDate('created_at', $today)
            ->select(
                DB::raw('HOUR(created_at) as hour'),
                DB::raw('SUM(total_price) as total')
            )
            ->groupBy('hour')
            ->get()
            ->pluck('total', 'hour')
            ->toArray();

        $totalTodayIncome = array_sum($todayIncome);

        // Get yesterday's income for comparison
        $yesterday = Carbon::yesterday();
        $yesterdayIncome = TransactionReport::whereDate('created_at', $yesterday)->sum('total_price');

        // Calculate percentage change
        $percentageChange = 0;
        if ($yesterdayIncome > 0) {
            $percentageChange = (($totalTodayIncome - $yesterdayIncome) / $yesterdayIncome) * 100;
        }

        // Get device status statistics
        $deviceStats = Device::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->get()
            ->map(function ($stat) {
                return [
                    'status' => $stat->status,
                    'total' => $stat->total,
                    'color' => match($stat->status) {
                        'Tersedia' => 'green-500',
                        'Berjalan' => 'blue-500',
                        'Pending' => 'yellow-500',
                        'Selesai' => 'gray-500',
                        'Maintenance' => 'red-500',
                        default => 'gray-500'
                    }
                ];
            });

        // Default to weekly data
        $chartData = $this->getChartData('week');

        return view('admin.dashboard', compact(
            'totalDevices',
            'usedDevices',
            'availableDevices',
            'maintenanceDevices',
            'totalCashiers',
            'totalTodayIncome',
            'todayIncome',
            'percentageChange',
            'chartData',
            'deviceStats'
        ));
    }

    public function getCurrentTime()
    {
        return response()->json([
            'time' => Carbon::now()->format('H:i:s'),
            'date' => Carbon::now()->isoFormat('dddd, D MMMM Y')
        ]);
    }

    public function getDashboardStats()
    {
        $today = Carbon::today();

        $stats = [
            'devices' => [
                'total' => Device::count(),
                'used' => Device::whereIn('status', ['Berjalan', 'Pending'])->count(),
                'available' => Device::where('status', 'Tersedia')->count(),
                'maintenance' => Device::where('status', 'Maintenance')->count()
            ],
            'income' => [
                'today' => TransactionReport::whereDate('created_at', $today)->sum('total_price'),
                'transactions' => TransactionReport::whereDate('created_at', $today)->count()
            ]
        ];

        return response()->json($stats);
    }

    public function getChartData(string $period = 'week', ?string $startDate = null, ?string $endDate = null)
    {
        $query = TransactionReport::query();
        $format = match($period) {
            'day' => '%H:00',
            'week' => '%a',
            'month' => '%d',
            'year' => '%b',
            'custom' => '%Y-%m-%d',
        };

        if ($startDate && $endDate) {
            $query->whereBetween('created_at', [
                Carbon::parse($startDate)->startOfDay(),
                Carbon::parse($endDate)->endOfDay()
            ]);
        } else {
            // Default date ranges
            $query->whereBetween('created_at', match($period) {
                'day' => [Carbon::today(), Carbon::today()->endOfDay()],
                'week' => [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()],
                'month' => [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()],
                'year' => [Carbon::now()->startOfYear(), Carbon::now()->endOfYear()],
                default => [Carbon::now()->subDays(6), Carbon::now()]
            });
        }

        $data = $query->select(
            DB::raw("DATE_FORMAT(created_at, '$format') as label"),
            DB::raw('SUM(total_price) as total'),
            DB::raw('COUNT(*) as transactions'),
            DB::raw('DATE(created_at) as date')
        )
        ->groupBy('label', 'date')
        ->orderBy('date')
        ->get();

        return [
            'labels' => $data->pluck('label'),
            'data' => $data->pluck('total'),
            'transactions' => $data->pluck('transactions')
        ];
    }

    public function updateChartData(Request $request)
    {
        $period = $request->input('period', 'week');
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');

        $chartData = $this->getChartData($period, $startDate, $endDate);
        return response()->json($chartData);
    }
}
