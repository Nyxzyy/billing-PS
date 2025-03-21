@extends('admin.layout-admin')

@section('title', 'Management Billing')
@section('breadcrumb', 'Management Billing')

@section('content')
    <div class="max-w-screen-xl mx-auto px-2 md:px-2">
        <h1 class="text-xl md:text-3xl font-bold">Management Billing</h1>
        <p class="text-[#414141] mb-8">Atur dan kelola paket billing dengan menentukan nama, durasi, dan harga.</p>

        <div class="relative overflow-x-auto shadow-md sm:rounded-lg bg-white p-6">
            <div class="flex flex-col md:flex-row md:justify-end md:items-center gap-2">
                <div class="relative w-full md:w-1/5">
                    <svg class="absolute left-3 top-2.5 w-4 h-4 text-[#6D717F]" xmlns="http://www.w3.org/2000/svg"
                        width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="11" cy="11" r="8"></circle>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                    </svg>
                    <input type="text" placeholder="Ketik untuk mencari"
                        class="text-[#6D717F] text-sm w-full pl-8 py-2 border border-[#c4c4c4] rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <button onclick="openModal('modalAddPaket')"
                    class="bg-[#3E81AB] text-white px-4 py-1.5 rounded text-sm flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="12" y1="8" x2="12" y2="16"></line>
                        <line x1="8" y1="12" x2="16" y2="12"></line>
                    </svg>
                    Tambah Paket
                </button>
            </div>
            <div class="p-4">
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-[#3E81AB]">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                        No</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                        Nama Paket Billing</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                        Durasi</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                        Harga (Rp)</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                        Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($packages as $index => $package)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            {{ $packages->firstItem() + $index }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $package->package_name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            @if ($package->duration_hours > 0)
                                                {{ $package->duration_hours }} Jam
                                            @endif
                                            @if ($package->duration_minutes > 0)
                                                {{ $package->duration_minutes }} Menit
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            {{ number_format($package->total_price, 0, ',', '.') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm space-x-2">
                                            <button onclick="openModal('modalEditPaket')"
                                                class="text-[#3E81AB] hover:text-[#2C5F7C] font-medium flex items-center gap-1 cursor-pointer">Edit</button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-4 whitespace-nowrap text-sm text-center">Tidak ada
                                            paket billing</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="flex items-center justify-between mt-4 text-sm text-gray-600">
                    <p>Showing {{ $packages->firstItem() ?? 0 }} - {{ $packages->lastItem() ?? 0 }} of
                        {{ $packages->total() ?? 0 }}</p>
                    <div class="flex space-x-2">
                        {{ $packages->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
