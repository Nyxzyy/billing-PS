<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        return view('kasir.dashboard', [
            'today' => now()->translatedFormat('l, d F Y H:i:s') 
        ]);
    }
}
