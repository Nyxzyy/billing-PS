@extends('admin.layout-admin')

@section('title', 'Laporan')
@section('breadcrumb', 'Laporan')

@section('content')
    <div class="max-w-screen-xl mx-auto px-2 md:px-2">
        <h1 class="text-xl md:text-3xl font-bold">Laporan Device</h1>
        <p class="text-[#414141] mb-8">Pantau dan analisis laporan device dibawah ini dengan filter harian, mingguan, dan bulanan.</p>

        <div class="relative overflow-x-auto shadow-md sm:rounded-lg bg-white p-6">
            <div class="flex flex-col md:flex-row md:justify-end md:items-center gap-2">
                <div class="relative w-full md:w-1/5">
                    <svg class="absolute left-3 top-2.5 w-4 h-4 text-[#6D717F]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                    <input type="text" placeholder="Cari..." class="text-[#6D717F] w-full pl-8 py-1.5 border border-[#c4c4c4] rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <button class="bg-[#3E81AB] text-white px-4 py-1.5 rounded text-sm flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="16"></line><line x1="8" y1="12" x2="16" y2="12"></line></svg>
                    Tambah Paket
                </button>
            </div>
            <div class="p-4">
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-[#3E81AB]">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">No</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Nama Perangkat</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Jenis Paket</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Waktu Paket</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Waktu Mulai</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Waktu Berhenti</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Harga (Rp)</th>
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
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">2</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm"></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">Menit</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm"></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm"></td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr class="bg-[#3E81AB] text-white">
                                    <td class="px-6 py-3 text-sm text-center" colspan="2">Error atau Gangguan: 3 Kali</td>
                                    <td class="px-6 py-3 text-sm text-center" colspan="2">Total Waktu Pemakaian: 325 Jam</td>
                                    <td class="px-6 py-3 text-sm text-center" colspan="2">Total Booking: 350 Kali</td>
                                    <td class="px-6 py-3 text-sm">Total Pendapatan: Rp 782.000</td>
                                </tr>
                            </tfoot>
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