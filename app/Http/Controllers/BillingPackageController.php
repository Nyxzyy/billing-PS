<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BillingPackage;
use Carbon\Carbon;

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
        $validated = $request->validate([
            'package_name'      => 'required|string|max:100',
            'duration_hours'    => [
                'required',
                'min:0',
                function ($attribute, $value, $fail) use ($request) {
                    if ($value == 0 && $request->duration_minutes == 0) {
                        $fail('Durasi tidak boleh 0 jam 0 menit. ');
                    }
                    if ($value === '00') {
                        $fail('Format jam tidak valid (Isikan "0" Saja).');
                    }
                },
            ],
            'duration_minutes'  => [
                'required',
                'min:0',
                'max:59',
                function ($attribute, $value, $fail) {
                    if ($value === '00') {
                        $fail('Format menit tidak valid (Isikan "0" Saja).');
                    }
                },
            ],
            'total_price'       => 'required|numeric|min:0',
            'active_days'       => 'required|array',
            'active_days.*'     => 'in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu',
            'active_hours_start' => 'required|date_format:H:i',
            'active_hours_end'   => [
                'required',
                'date_format:H:i',
                function ($attribute, $value, $fail) use ($request) {
                    $start = Carbon::createFromFormat('H:i', $request->active_hours_start);
                    $end = Carbon::createFromFormat('H:i', $value);

                    // Jika jam akhir lebih kecil dari jam mulai, berarti melewati tengah malam
                    if ($end < $start) {
                        // Tambahkan 24 jam ke jam akhir untuk perhitungan
                        $end->addDay();
                    }
                },
            ],
        ]);

        try {
            BillingPackage::create([
                'package_name'       => $request->package_name,
                'duration_hours'     => $request->duration_hours,
                'duration_minutes'   => $request->duration_minutes,
                'total_price'        => $request->total_price,
                'active_days'        => $request->active_days,
                'active_hours_start' => $request->active_hours_start,
                'active_hours_end'   => $request->active_hours_end,
            ]);

            return redirect()->route('admin.paketBilling')
                ->with('success', 'Paket berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Gagal menambahkan paket'])
                ->withInput();
        }
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

        $validated = $request->validate([
            'package_name'      => 'required|string|max:100',
            'duration_hours'    => [
                'required',
                'min:0',
                function ($attribute, $value, $fail) use ($request) {
                    if ($value == 0 && $request->duration_minutes == 0) {
                        $fail('Durasi tidak boleh 0 jam 0 menit. ');
                    }
                    if ($value === '00') {
                        $fail('Format jam tidak valid (Isikan "0" Saja).');
                    }
                },
            ],
            'duration_minutes'  => [
                'required',
                'min:0',
                'max:59',
                function ($attribute, $value, $fail) {
                    if ($value === '00') {
                        $fail('Format menit tidak valid (Isikan "0" Saja).');
                    }
                },
            ],
            'total_price'       => 'required|numeric|min:0',
            'active_days'       => 'required|array',
            'active_days.*'     => 'in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu',
            'active_hours_start' => 'required|date_format:H:i',
            'active_hours_end'   => [
                'required',
                'date_format:H:i',
                function ($attribute, $value, $fail) use ($request) {
                    $start = Carbon::createFromFormat('H:i', $request->active_hours_start);
                    $end = Carbon::createFromFormat('H:i', $value);

                    // Jika jam akhir lebih kecil dari jam mulai, berarti melewati tengah malam
                    if ($end < $start) {
                        // Tambahkan 24 jam ke jam akhir untuk perhitungan
                        $end->addDay();
                    }
                },
            ],
        ]);

        try {
            $package->update([
                'package_name'       => $request->package_name,
                'duration_hours'     => $request->duration_hours,
                'duration_minutes'   => $request->duration_minutes,
                'total_price'        => $request->total_price,
                'active_days'        => $request->active_days,
                'active_hours_start' => $request->active_hours_start,
                'active_hours_end'   => $request->active_hours_end,
            ]);

            return redirect()->route('admin.paketBilling')
                ->with('success', 'Paket berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Gagal memperbarui paket'])
                ->withInput();
        }
    }

    public function destroy($id)
    {
        $package = BillingPackage::findOrFail($id);
        $package->delete();

        return redirect()->route('admin.paketBilling')
            ->with('success', 'Paket berhasil dihapus.');
    }
}
