<?php

namespace App\Http\Controllers;

use App\Models\BillingOpen;
use Illuminate\Http\Request;
use App\Models\OpenBillingPromo;

class OpenBillingController extends Controller
{
    public function index()
    {
        $openBilling = BillingOpen::first();
        $promos = OpenBillingPromo::paginate(10); 
        return view('Admin.openBilling', compact('openBilling', 'promos'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'price_per_hour' => 'required|numeric|min:0',
            'minute_count' => 'required|integer|min:1',
            'price_per_minute' => 'required|numeric|min:0'
        ]);

        $openBilling = BillingOpen::first();
        if (!$openBilling) {
            $openBilling = new BillingOpen();
        }

        $openBilling->price_per_hour = $request->price_per_hour;
        $openBilling->minute_count = $request->minute_count;
        $openBilling->price_per_minute = $request->price_per_minute;
        $openBilling->save();

        return redirect()->back()->with('success', 'Pengaturan open billing berhasil disimpan');
    }
}
