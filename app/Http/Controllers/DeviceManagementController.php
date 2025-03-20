<?php

namespace App\Http\Controllers;

use App\Models\Device;
use Illuminate\Http\Request;

class DeviceManagementController extends Controller
{
    /**
     * Display a listing of devices.
     */
    public function index(Request $request)
    {
        $query = Device::query();

        // Handle search
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%")
                  ->orWhere('ip_address', 'like', "%{$search}%");
            });
        }

        // Get paginated results
        $devices = $query->paginate(10);

        return view('admin.managePerangkat', [
            'devices' => $devices
        ]);
    }

    /**
     * Store a newly created device.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'ip_address' => 'required|string|max:45|unique:devices,ip_address'
        ]);

        Device::create($validated);

        return redirect()->route('admin.managePerangkat')
            ->with('success', 'Perangkat berhasil ditambahkan');
    }

    /**
     * Update the specified device.
     */
    public function update(Request $request, Device $device)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'ip_address' => 'required|string|max:45|unique:devices,ip_address,' . $device->id
        ]);

        $device->update($validated);

        return redirect()->route('admin.managePerangkat')
            ->with('success', 'Perangkat berhasil diperbarui');
    }

    /**
     * Remove the specified device.
     */
    public function destroy(Device $device)
    {
        $device->delete();

        return redirect()->route('admin.managePerangkat')
            ->with('success', 'Perangkat berhasil dihapus');
    }
}
