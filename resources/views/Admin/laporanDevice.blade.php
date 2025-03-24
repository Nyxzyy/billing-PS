@extends('admin.layout-admin')

@section('title', 'Laporan')
@section('breadcrumb', 'Laporan')

@section('content')
    <div class="max-w-screen-xl mx-auto px-2 md:px-2">
        <h1 class="text-xl md:text-3xl font-bold">Laporan Device</h1>
        <p class="text-[#414141] mb-8">Pantau dan analisis laporan device dibawah ini dengan filter harian, mingguan, dan
            bulanan.</p>

        <div class="relative overflow-x-auto shadow-md sm:rounded-lg bg-white p-6">
            <div class="flex flex-col md:flex-row md:justify-end md:items-center gap-2">
                <div
                    class="relative w-full md:w-1/5 flex items-center border rounded-lg text-[#6D717F] border-[#C0C0C0] px-3 py-1.5">
                    <button type="button" onclick="document.getElementById('start_date').showPicker()">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                            stroke-linejoin="round">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                            <line x1="16" y1="2" x2="16" y2="6"></line>
                            <line x1="8" y1="2" x2="8" y2="6"></line>
                            <line x1="3" y1="10" x2="21" y2="10"></line>
                        </svg>
                    </button>
                    <input type="date" id="start_date" name="filter_start_date" placeholder="Tanggal Mulai"
                        class="text-[#6D717F] text-sm w-full px-3 outline-none bg-transparent border-none appearance-none">
                </div>

                <div
                    class="relative w-full md:w-1/5 flex items-center border rounded-lg text-[#6D717F] border-[#C0C0C0] px-3 py-1.5">
                    <button type="button" onclick="document.getElementById('end_date').showPicker()">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                            stroke-linejoin="round">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                            <line x1="16" y1="2" x2="16" y2="6"></line>
                            <line x1="8" y1="2" x2="8" y2="6"></line>
                            <line x1="3" y1="10" x2="21" y2="10"></line>
                        </svg>
                    </button>
                    <input type="date" id="end_date" name="filter_end_date" placeholder="Tanggal Akhir"
                        class="text-[#6D717F] text-sm w-full px-3 outline-none bg-transparent border-none appearance-none">
                </div>
                <select class="px-6 border rounded-lg border-[#C0C0C0] py-2 text-[#969696] text-sm">
                    <option>Ketik atau Pilih Perangkat</option>
                </select>
                <div class="relative w-full md:w-1/5">
                    <svg class="absolute left-3 top-2 w-4 h-4 text-[#6D717F]" xmlns="http://www.w3.org/2000/svg"
                        width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="11" cy="11" r="8"></circle>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                    </svg>
                    <input type="text" placeholder="Ketik untuk mencari di tabel"
                        class="text-[#6D717F] text-sm w-full pl-8 py-1.5 border border-[#c4c4c4] rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div class="relative" x-data="{ isOpen: false }">
                    <button @click="isOpen = !isOpen"
                        class="bg-[#3E81AB] text-white px-4 py-1.5 rounded text-sm flex items-center gap-2 cursor-pointer">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path d="M3 15v4c0 1.1.9 2 2 2h14a2 2 0 0 0 2-2v-4M17 9l-5 5-5-5M12 12.8V2.5" />
                        </svg>
                        Download Laporan
                    </button>

                    <!-- Dropdown menu -->
                    <div x-show="isOpen" @click.away="isOpen = false"
                        class="absolute right-0 mt-2 w-80 bg-white rounded-md shadow-lg z-50">
                        <div class="p-4">
                            <h3 class="text-sm font-medium text-gray-900 mb-3">Filter Laporan</h3>
                            <form action="{{ route('admin.laporan-kendala.download-pdf') }}" method="GET">
                                <!-- Date Range -->
                                <div class="space-y-3 mb-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Mulai</label>
                                        <div class="relative">
                                            <input type="date" id="download_start_date" name="start_date"
                                                class="w-full rounded-md border border-gray-300 py-2 px-3 focus:border-blue-500 focus:ring-blue-500 cursor-pointer appearance-none">
                                            <button type="button"
                                                onclick="document.getElementById('download_start_date').showPicker()"
                                                class="absolute right-2 top-1/2 transform -translate-y-1/2">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="text-gray-500">
                                                    <rect x="3" y="4" width="18" height="18" rx="2"
                                                        ry="2"></rect>
                                                    <line x1="16" y1="2" x2="16" y2="6">
                                                    </line>
                                                    <line x1="8" y1="2" x2="8" y2="6">
                                                    </line>
                                                    <line x1="3" y1="10" x2="21" y2="10">
                                                    </line>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Akhir</label>
                                        <div class="relative">
                                            <input type="date" id="download_end_date" name="end_date"
                                                class="w-full rounded-md border border-gray-300 py-2 px-3 focus:border-blue-500 focus:ring-blue-500 cursor-pointer appearance-none">
                                            <button type="button"
                                                onclick="document.getElementById('download_end_date').showPicker()"
                                                class="absolute right-2 top-1/2 transform -translate-y-1/2">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="text-gray-500">
                                                    <rect x="3" y="4" width="18" height="18" rx="2"
                                                        ry="2"></rect>
                                                    <line x1="16" y1="2" x2="16" y2="6">
                                                    </line>
                                                    <line x1="8" y1="2" x2="8" y2="6">
                                                    </line>
                                                    <line x1="3" y1="10" x2="21" y2="10">
                                                    </line>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Download Buttons -->
                                <div class="space-y-2">
                                    <button type="submit" name="download_type" value="filtered"
                                        class="w-full bg-[#3E81AB] text-white px-4 py-2 rounded text-sm hover:bg-[#357099] transition-colors cursor-pointer">
                                        Download Data Terfilter
                                    </button>
                                    <button type="submit" name="download_type" value="all"
                                        class="w-full bg-gray-100 text-gray-700 px-4 py-2 rounded text-sm hover:bg-gray-200 transition-colors cursor-pointer">
                                        Download Semua Data
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="p-4">
                <div class="bg-white rounded-lg shadow p-4 mb-4">
                    <div class="flex justify-between items-center mb-2">
                        <h2 class="text-lg font-semibold">Informasi Device</h2>
                        <span id="shiftStatus">
                        </span>
                    </div>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div>
                            <p class="text-sm text-gray-600">Kendala Pada Perangkat</p>
                            <p class="font-semibold">{{ $summary['total_kendala'] }} Kali</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Total Waktu Pemakaian</p>
                            <p class="font-semibold">{{ $summary['total_waktu_pakai'] }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Total Booking</p>
                            <p class="font-semibold">{{ $summary['total_booking'] }} Transaksi</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Total Pendapatan</p>
                            <p class="font-semibold">Rp {{ number_format($summary['total_pendapatan'], 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-[#3E81AB]">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                        No</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                        Nama Perangkat</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                        Jenis Paket</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                        Waktu Paket</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                        Waktu Mulai</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                        Waktu Berhenti</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                        Harga (Rp)</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($transactions as $index => $transaction)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $loop->iteration }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $transaction->device->name }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $transaction->package_name }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $transaction->package_time }}
                                            Menit</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            {{ $transaction->start_time->format('H:i:s') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            {{ $transaction->end_time ? $transaction->end_time->format('H:i:s') : 'Berjalan' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            {{ number_format($transaction->total_price, 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="flex items-center justify-between mt-4 text-sm text-gray-600">
                    <p>Showing {{ $transactions->firstItem() }} - {{ $transactions->lastItem() }} of
                        {{ $transactions->total() }}</p>
                    <div class="flex space-x-2">
                        {{ $transactions->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
