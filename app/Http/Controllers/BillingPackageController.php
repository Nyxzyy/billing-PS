<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BillingPackage;

class BillingPackageController extends Controller
{
    public function index()
    {
        $packages = BillingPackage::paginate(10);
        return view('Admin.paketBilling', compact('packages'));
    }

    public function search(Request $request)
    {
        $query = $request->input('query');

        $packages = BillingPackage::where('package_name', 'LIKE', "%{$query}%")
            ->orWhere('total_price', 'LIKE', "%{$query}%")
            ->paginate(10);

        return response()->json([
            'html' => view('Admin.partials.paketBilling-table', compact('packages'))->render()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'package_name'      => 'required|string|max:100',
            'duration_hours'    => 'required|integer|min:0',
            'duration_minutes'  => 'required|integer|min:0|max:59',
            'total_price'       => 'required|numeric|min:0',
            'active_days'       => 'required|array',
            'active_days.*'     => 'in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu',
        ]);

        BillingPackage::create([
            'package_name'     => $request->package_name,
            'duration_hours'   => $request->duration_hours,
            'duration_minutes' => $request->duration_minutes,
            'total_price'      => $request->total_price,
            'active_days'      => $request->active_days,
        ]);

        return redirect()->route('admin.paketBilling')
            ->with('success', 'Paket berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $packages = BillingPackage::paginate(10);
        $editPackage = BillingPackage::findOrFail($id);
        return view('Admin.paketBilling', compact('packages', 'editPackage'));
    }

    public function update(Request $request, $id)
    {
        $package = BillingPackage::findOrFail($id);

        $request->validate([
            'package_name'      => 'required|string|max:100',
            'duration_hours'    => 'required|integer|min:0',
            'duration_minutes'  => 'required|integer|min:0|max:59',
            'total_price'       => 'required|numeric|min:0',
            'active_days'       => 'required|array',
            'active_days.*'     => 'in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu',
        ]);

        $package->update([
            'package_name'     => $request->package_name,
            'duration_hours'   => $request->duration_hours,
            'duration_minutes' => $request->duration_minutes,
            'total_price'      => $request->total_price,
            'active_days'      => $request->active_days,
        ]);

        return redirect()->route('admin.paketBilling')
            ->with('success', 'Paket berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $package = BillingPackage::findOrFail($id);
        $package->delete();

        return redirect()->route('admin.paketBilling')
            ->with('success', 'Paket berhasil dihapus.');
    }
}