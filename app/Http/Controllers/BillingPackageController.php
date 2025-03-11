<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BillingPackage;

class BillingPackageController extends Controller
{
    public function index()
    {
        $packages = BillingPackage::all();
        return view('billing_packages.index', compact('packages'));
    }

    public function create()
    {
        return view('billing_packages.create');
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
            'active_days'      => implode(',', $request->active_days),
        ]);

        return redirect()->route('billing-packages.index')->with('success', 'Billing Package created successfully.');
    }

    public function show($id)
    {
        $package = BillingPackage::findOrFail($id);
        return view('billing_packages.show', compact('package'));
    }

    public function edit($id)
    {
        $package = BillingPackage::findOrFail($id);
        return view('billing_packages.edit', compact('package'));
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
            'active_days'      => implode(',', $request->active_days),
        ]);

        return redirect()->route('billing-packages.index')->with('success', 'Billing Package updated successfully.');
    }

    public function destroy($id)
    {
        $package = BillingPackage::findOrFail($id);
        $package->delete();

        return redirect()->route('billing-packages.index')->with('success', 'Billing Package deleted successfully.');
    }
}
