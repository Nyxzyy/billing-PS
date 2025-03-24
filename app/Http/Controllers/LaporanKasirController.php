<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\CashierReport;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LaporanKasirController extends Controller
{
    public function index(Request $request)
    {
        $query = CashierReport::with('cashier')
            ->select('cashier_reports.*');

        $summary = [
            'total_work_hours' => $query->sum('total_work_hours'),
            'total_transactions' => $query->sum('total_transactions'),
            'total_revenue' => $query->sum('total_revenue'),
        ];

        $reports = $query->orderBy('work_date', 'desc')
            ->paginate(10);

        return view('admin.laporanKasir', compact('reports', 'summary'));
    }
}
