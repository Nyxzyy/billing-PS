@extends('kasir.layout-kasir')

@section('title', 'Laporan')
@section('breadcrumb', 'Laporan')

@section('content')
    <div class="max-w-screen-xl mx-auto px-2 md:px-2">
        <h1 class="text-xl md:text-3xl font-bold">Laporan</h1>
        <p class="text-[#414141] mb-8">Lihat rekap transaksi kasir, total pendapatan, dan tutup buku dengan konfirmasi cetak
            laporan.</p>
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg bg-white p-6">
            <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-5">
                <div class="text-md mb-4 md:mb-0">
                    <p>Nama Kasir : <span class="font-bold">{{ Auth::user()->name }}</span></p>
                </div>
                <div class="flex space-x-2">
                    <button class="bg-[#3E81AB] text-white px-4 py-1.5 rounded text-sm flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path d="M3 15v4c0 1.1.9 2 2 2h14a2 2 0 0 0 2-2v-4M17 9l-5 5-5-5M12 12.8V2.5" />
                        </svg>
                        Download Laporan
                    </button>
                    @if($currentShift && !$currentShift->shift_end)
                        <button onclick="endShift()" class="bg-[#FB2C36] text-white px-4 py-1.5 rounded text-sm flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M3 3h18v18H3zM15 9l-6 6m0-6l6 6" />
                            </svg>
                            Tutup Buku
                        </button>
                    @endif
                </div>
            </div>
            <div class="border-t border-[#DFDFDF] w-full mt-2 pt-2 mb-4"></div>

            <div class="p-4">
                <!-- Shift Information -->
                <div class="bg-white rounded-lg shadow p-4 mb-4">
                    <div class="flex justify-between items-center mb-2">
                        <h2 class="text-lg font-semibold">Informasi Shift</h2>
                    </div>
                    @if($currentShift)
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            <div>
                                <p class="text-sm text-gray-600">Mulai Shift</p>
                                <p class="font-medium">{{ \Carbon\Carbon::parse($currentShift->shift_start)->format('H:i') }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Waktu Kerja</p>
                                <p class="font-medium">{{ number_format($currentShift->total_work_hours, 1) }} Jam</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Total Transaksi</p>
                                <p class="font-medium">{{ $currentShift->total_transactions }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Total Pendapatan</p>
                                <p class="font-medium">Rp {{ number_format($currentShift->total_revenue, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    @else
                        <p class="text-sm text-gray-600">Tidak ada shift aktif</p>
                    @endif
                </div>

                <!-- Transaction Table -->
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <div class="p-4">
                        <h2 class="text-lg font-semibold">Daftar Transaksi</h2>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Device</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Paket</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Durasi</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mulai</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Selesai</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Struk</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($transactions as $transaction)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $transaction['device_name'] }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $transaction['package_name'] }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $transaction['package_time'] }} Menit</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $transaction['start_time'] }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $transaction['end_time'] }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">Rp {{ number_format($transaction['total_price'], 0, ',', '.') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <button onclick="printReceipt({{ $transaction['id'] }})" class="text-[#3E81AB] hover:text-[#2C5F7C] font-medium flex items-center gap-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <polyline points="6 9 6 2 18 2 18 9"></polyline>
                                                <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path>
                                                <rect x="6" y="14" width="12" height="8"></rect>
                                            </svg>
                                            Cetak
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    function endShift() {
        if (!confirm('Apakah anda yakin ingin mengakhiri shift?')) {
            return;
        }

        fetch('/shift/end', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                showNotification('success', 'Shift berhasil diakhiri');
                // Reload page to update shift information
                window.location.reload();
            } else {
                showNotification('error', data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('error', 'Terjadi kesalahan saat mengakhiri shift');
        });
    }

    function printReceipt(transactionId) {
        // Add print receipt functionality here
        window.open(`/print-receipt/${transactionId}`, '_blank', 'width=400,height=600');
    }
    </script>
@endsection
