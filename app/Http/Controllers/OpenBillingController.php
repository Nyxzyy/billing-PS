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

    public function search(Request $request)
    {
        $query = $request->input('query');

        $packages = BillingPackage::where('min_hours', 'LIKE', "%{$query}%")
            ->orWhere('min_minutes', 'LIKE', "%{$query}%")
            ->orWhere('discount_price', 'LIKE', "%{$query}%")
            ->paginate(10);

        return response()->json([
            'html' => view('Admin.partials.paketBilling-table', compact('packages'))->render()
        ]);
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

    public function storePromo(Request $request)
    {
        $request->validate([
            'min_hours' => 'required|integer|min:0',
            'min_minutes' => 'required|integer|min:0',
            'discount_price' => 'required|numeric|min:0',
        ]);

        OpenBillingPromo::create($request->only('min_hours', 'min_minutes', 'discount_price'));

        return redirect()->back()->with('success', 'Promo berhasil ditambahkan');
    }

    public function updatePromo(Request $request, $id)
    {
        $request->validate([
            'min_hours' => 'required|integer|min:0',
            'min_minutes' => 'required|integer|min:0',
            'discount_price' => 'required|numeric|min:0',
        ]);

        $promo = OpenBillingPromo::findOrFail($id);
        $promo->update($request->only('min_hours', 'min_minutes', 'discount_price'));

        return redirect()->back()->with('success', 'Promo berhasil diperbarui');
    }

    public function deletePromo($id)
    {
        $promo = OpenBillingPromo::findOrFail($id);
        $promo->delete();

        return redirect()->back()->with('success', 'Promo berhasil dihapus');
    }
}
