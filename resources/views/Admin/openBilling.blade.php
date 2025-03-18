@extends('admin.layout-admin')

@section('title', 'Management Billing')
@section('breadcrumb', 'Management Billing')

@section('content')
    <div class="max-w-screen-xl mx-auto px-2 md:px-2">
        <h1 class="text-xl md:text-3xl font-bold">Management Billing</h1>
        <p class="text-[#414141] mb-5">Atur dan kelola paket billing dengan menentukan nama, durasi, dan harga.</p>

        <div class="p-5 bg-white shadow-md rounded-lg mb-6">
            <h2 class="text-lg font-semibold mb-3">Pengaturan Open Time</h2>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Harga per Jam (Rp)</label>
                <input type="text" placeholder="Contoh: 6000" class="w-full mt-1 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="flex gap-2 mb-4">
                <div class="w-1/2">
                    <label class="block text-sm font-medium text-gray-700">Harga per Menit (Rp)</label>
                    <input type="text" placeholder="Menit (misal: 10)" class="w-full mt-1 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div class="w-1/2">
                    <label class="block text-sm font-medium text-gray-700">Harga (Rp)</label>
                    <input type="text" placeholder="Harga (Rp)" class="w-full mt-1 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>
            <button class="w-full bg-[#39C65B] text-white py-2 rounded-lg hover:bg-green-600">Simpan Pengaturan</button>
        </div>

        <div class="relative overflow-x-auto shadow-md sm:rounded-lg bg-white p-6 mb-2">
            <div class="flex flex-col md:flex-row md:justify-end md:items-center gap-2">
                <div class="relative w-full md:w-1/5">
                    <svg class="absolute left-3 top-2.5 w-4 h-4 text-[#6D717F]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                    <input type="text" placeholder="Cari..." class="text-[#6D717F] w-full pl-8 py-1.5 border border-[#c4c4c4] rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <button class="bg-[#3E81AB] text-white px-4 py-1.5 rounded text-sm flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="16"></line><line x1="8" y1="12" x2="16" y2="12"></line></svg>
                    Tambah Promo
                </button>
            </div>
            <div class="p-4">
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-[#3E81AB]">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">No</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Nama Paket Billing</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Durasi Promo</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Diskon (Rp)</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">1</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm"></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">Menit</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm"></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm"></td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">1</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm"></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">Menit</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm"></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm"></td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">1</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm"></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">Menit</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm"></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="flex items-center justify-between mt-4 text-sm text-gray-600">
                <p>Showing 1 - 10 of 1000</p>
                <div class="flex space-x-2">
                    <button class="px-3 py-1 border rounded-md">Previous</button>
                    <span class="px-3 py-1 border bg-blue-100 rounded-md">1</span>
                    <button class="px-3 py-1 border rounded-md">Next</button>
                </div>
            </div>
        </div>
    </div>
@endsection