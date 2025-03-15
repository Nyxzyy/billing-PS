@extends('kasir.layout-kasir')

@section('title', 'Laporan')
@section('breadcrumb', 'Laporan')

@section('content')
<div class="max-w-screen-xl mx-auto px-2 md:px-2">
    <h1 class="text-xl md:text-3xl font-bold">Laporan</h1>
    <p class="text-[#414141] mb-8">Lihat rekap transaksi kasir, total pendapatan, dan tutup buku dengan konfirmasi cetak laporan.</p>
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg bg-white p-6">
        <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-5">
            <div class="text-md mb-4 md:mb-0">
                <p>Nama Kasir : <span class="font-bold">Abdullah Ali</span></p>
                <p>Waktu Kerja : <span class="font-bold">6 Jam</span></p>
            </div>
            <div class="flex space-x-2">
                <button class="bg-[#3E81AB] text-white px-4 py-1.5 rounded text-sm flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M3 15v4c0 1.1.9 2 2 2h14a2 2 0 0 0 2-2v-4M17 9l-5 5-5-5M12 12.8V2.5"/>
                    </svg>
                    Download Laporan
                </button>
                <button class="bg-[#FB2C36] text-white px-4 py-1.5 rounded text-sm flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M3 3h18v18H3zM15 9l-6 6m0-6l6 6"/>
                    </svg>
                    Tutup Buku
                </button>
            </div>
        </div>
        <div class="border-t border-[#DFDFDF] w-full mt-2 pt-2 mb-4"></div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-center border-collapse overflow-hidden rounded-t-lg text-sm">
                <thead>
                    <tr class="bg-[#3E81AB] text-white rounded-t-lg">
                        <th class="p-2">No</th>
                        <th class="p-2">Nama Device</th>
                        <th class="p-2">Jenis Paket</th>
                        <th class="p-2">Waktu Paket</th>
                        <th class="p-2">Waktu Mulai</th>
                        <th class="p-2">Waktu Berhenti</th>
                        <th class="p-2">Harga (Rp)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="odd:bg-white even:bg-gray-100">
                        <td class="p-2 text-center">1</td>
                        <td class="p-2 text-center">PS 1</td>
                        <td class="p-2 text-center">Regular</td>
                        <td class="p-2 text-center">1 Jam</td>
                        <td class="p-2 text-center">10:34:00</td>
                        <td class="p-2 text-center">11:28:00</td>
                        <td class="p-2 text-center">10.000</td>
                    </tr>
                    <tr class="odd:bg-white even:bg-gray-100">
                        <td class="p-2 text-center">2</td>
                        <td class="p-2 text-center">PS 2</td>
                        <td class="p-2 text-center">Regular</td>
                        <td class="p-2 text-center">1 Jam</td>
                        <td class="p-2 text-center">10:45:00</td>
                        <td class="p-2 text-center">11:45:00</td>
                        <td class="p-2 text-center">10.000</td>
                    </tr>
                </tbody>            
                <tfoot>
                    <tr class="bg-[#3E81AB] text-white">
                        <td colspan="6" class="p-2 pr-12 text-right font-bold">Total Pendapatan</td>
                        <td class="p-2 text-center font-bold">Rp. 10.000</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
@endsection
