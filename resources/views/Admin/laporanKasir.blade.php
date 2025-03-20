@extends('admin.layout-admin')

@section('title', 'Laporan Kasir')
@section('breadcrumb', 'Laporan')

@section('content')
    <div class="max-w-screen-xl mx-auto px-2 md:px-2">
        <h1 class="text-xl md:text-3xl font-bold">Laporan Kasir</h1>
        <p class="text-[#414141] mb-8">Pantau dan analisis laporan per kasir dibawah ini dengan filter harian, mingguan, dan bulanan.</p>

        <div class="relative overflow-x-auto shadow-md sm:rounded-lg bg-white p-6">
            <div class="flex flex-col md:flex-row md:justify-end md:items-center gap-2">
                <div class="relative w-full md:w-1/5 flex items-center border rounded-lg text-[#6D717F] border-[#C0C0C0] px-3 py-1.5">
                    <button type="button" onclick="document.getElementById('dateInput').showPicker()">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                            <line x1="16" y1="2" x2="16" y2="6"></line>
                            <line x1="8" y1="2" x2="8" y2="6"></line>
                            <line x1="3" y1="10" x2="21" y2="10"></line>
                        </svg>
                    </button>
                    <input type="date" id="dateInput" placeholder="Pilih Tanggal" class="text-[#6D717F] text-sm w-full px-3 outline-none bg-transparent border-none appearance-none">
                    <button type="button" onclick="document.getElementById('dateInput').value = ''" class="text-[#6D717F] pl-2 border-l border-[#C0C0C0]">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M2.5 2v6h6M21.5 22v-6h-6"/>
                            <path d="M22 11.5A10 10 0 0 0 3.2 7.2M2 12.5a10 10 0 0 0 18.8 4.2"/>
                        </svg>
                    </button>
                </div>
                <select class="px-2 border rounded-lg border-[#C0C0C0] py-2 text-[#969696] text-sm">
                    <option>Ketik atau Pilih Nama Kasir 1</option>
                </select>
                <div class="relative w-full md:w-1/5">
                    <svg class="absolute left-3 top-2 w-4 h-4 text-[#6D717F]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                    <input type="text" placeholder="Ketik untuk mencari di tabel" class="text-[#6D717F] text-sm w-full pl-8 py-1.5 border border-[#c4c4c4] rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <button class="bg-[#3E81AB] text-white px-4 py-1.5 rounded text-sm flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3 15v4c0 1.1.9 2 2 2h14a2 2 0 0 0 2-2v-4M17 9l-5 5-5-5M12 12.8V2.5"/></svg>
                    Download Laporan
                </button>
            </div>
            <div class="p-4">
                <div class="bg-white rounded-lg shadow p-4 mb-4">
                    <div class="flex justify-between items-center mb-2">
                        <h2 class="text-lg font-semibold">Informasi Kasir</h2>
                        <span id="shiftStatus">
                        </span>
                    </div>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                        <div>
                            <p class="text-sm text-gray-600">Total Waktu Kerja</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Total Transaksi</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Total Pendapatan</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-[#3E81AB]">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">No</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Nama Kasir</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Total Transaksi</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Total Pendapatan (Rp)</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Jam Kerja</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Tanggal Kerja</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">1</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm"></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">Menit</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm"></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">2</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm"></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">Menit</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm"></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm"></td>
                                </tr>
                            </tbody>
                        </table>
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
    </div>
@endsection