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
                    <button id="btnDownload"
                        class="bg-[#3E81AB] text-white px-4 py-1.5 rounded text-sm flex items-center gap-2 cursor-pointer">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path d="M3 15v4c0 1.1.9 2 2 2h14a2 2 0 0 0 2-2v-4M17 9l-5 5-5-5M12 12.8V2.5" />
                        </svg>
                        Download Laporan
                    </button>
                    @if ($currentShift)
                        <button onclick="endShift()"
                            class="bg-[#FB2C36] text-white px-4 py-1.5 rounded text-sm flex items-center gap-2 cursor-pointer">
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
                <div class="bg-white rounded-lg shadow p-4 mb-4" data-shift-active="{{ $currentShift ? '1' : '0' }}">
                    <div class="flex justify-between items-center mb-2">
                        <h2 class="text-lg font-semibold">Informasi Shift</h2>
                        <span id="shiftStatus" class="{{ $currentShift ? 'text-green-500' : 'text-red-500' }}">
                        </span>
                    </div>
                    @if ($currentShift)
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            <div>
                                <p class="text-sm text-gray-600">Mulai Shift</p>
                                <p class="font-medium">
                                    {{ \Carbon\Carbon::parse($currentShift->shift_start)->format('H:i') }}</p>
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
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Device</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Paket</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Durasi</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Mulai</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Selesai</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Total</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Struk</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($transactions->whereBetween('start_time', [$currentShift->shift_start, $currentShift->shift_end ?? now()]) as $transaction)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $transaction['device_name'] }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $transaction['package_name'] }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $transaction['package_time'] }}
                                            Menit</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $transaction['start_time'] }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $transaction['end_time'] }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">Rp
                                            {{ number_format($transaction['total_price'], 0, ',', '.') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            <button onclick="printReceipt({{ $transaction['id'] }})"
                                                class="text-[#3E81AB] hover:text-[#2C5F7C] font-medium flex items-center gap-1 cursor-pointer">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <polyline points="6 9 6 2 18 2 18 9"></polyline>
                                                    <path
                                                        d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v-5a2 2 0 0 1-2 2h-2">
                                                    </path>
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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.23/jspdf.plugin.autotable.min.js"></script>

    <script>
        function endShift() {
            if (!confirm('Apakah anda yakin ingin mengakhiri shift?')) {
                return;
            }

            fetch('{{ route('shift.end') }}', {
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
                        setTimeout(() => {
                            window.location.reload();
                        }, 1000);
                    } else {
                        showNotification('error', data.message || 'Terjadi kesalahan saat mengakhiri shift');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showNotification('error', 'Terjadi kesalahan saat mengakhiri shift');
                });
        }

        function printReceipt(transactionId) {
            window.open(`/kasir/print-receipt/${transactionId}`, '_blank', 'width=400,height=600');
        }

        document.getElementById("btnDownload").addEventListener("click", function() {
            const {
                jsPDF
            } = window.jspdf;
            const doc = new jsPDF({
                orientation: "landscape"
            });

            // Set font size and style
            doc.setFontSize(16);
            doc.setFont(undefined, 'bold');
            doc.text("Laporan Daftar Transaksi", 14, 15);

            // Reset font
            doc.setFontSize(10);
            doc.setFont(undefined, 'normal');

            // Get cashier info from the page
            const cashierName = "{{ Auth::user()->name }}";
            @if ($currentShift)
                const shiftStart =
                    "{{ $currentShift->shift_start ? \Carbon\Carbon::parse($currentShift->shift_start)->format('H:i') : '-' }}";
                const workHours =
                    {{ $currentShift->shift_start ? \Carbon\Carbon::parse($currentShift->shift_start)->diffInHours(now()) : 0 }};
                const formattedWorkHours = workHours.toFixed(1);
                const totalTransactions = "{{ $currentShift->total_transactions }}";
                const totalRevenue = new Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR',
                    minimumFractionDigits: 0,
                    maximumFractionDigits: 0
                }).format({{ $currentShift->total_revenue }});
            @else
                const shiftStart = "-";
                const formattedWorkHours = "0.0";
                const totalTransactions = "0";
                const totalRevenue = new Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR',
                    minimumFractionDigits: 0,
                    maximumFractionDigits: 0
                }).format(0);
            @endif

            // Get current date and time
            const now = new Date();
            const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
            const months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September',
                'Oktober', 'November', 'Desember'
            ];
            const downloadTime =
                `${days[now.getDay()]}, ${now.getDate()} ${months[now.getMonth()]} ${now.getFullYear()} ${String(now.getHours()).padStart(2, '0')}:${String(now.getMinutes()).padStart(2, '0')}`;

            // Add cashier info
            const cashierInfo = [
                ['Nama Kasir:', cashierName],
                ['Mulai Shift:', shiftStart],
                ['Waktu Kerja:', `${formattedWorkHours} jam`],
                ['Total Transaksi:', totalTransactions],
                ['Total Pendapatan:', totalRevenue],
                ['Waktu Download:', downloadTime]
            ];

            // Add cashier info table
            doc.autoTable({
                body: cashierInfo,
                startY: 20,
                theme: 'plain',
                styles: {
                    fontSize: 10,
                    cellPadding: 1
                },
                columnStyles: {
                    0: {
                        fontStyle: 'bold',
                        cellWidth: 40
                    },
                    1: {
                        cellWidth: 100
                    }
                }
            });

            // Ambil elemen tabel transaksi
            const table = document.querySelector("table");

            // Hanya proses tabel jika ada transaksi
            if (table) {
                // Ambil header tabel, kecuali "Struk"
                const headers = [];
                table.querySelectorAll("thead tr th").forEach((th, index) => {
                    if (index !== 6) {
                        headers.push(th.innerText);
                    }
                });

                // Ambil data dari tabel, kecuali "Struk"
                const data = [];
                table.querySelectorAll("tbody tr").forEach(tr => {
                    const rowData = [];
                    tr.querySelectorAll("td").forEach((td, index) => {
                        if (index !== 6) {
                            rowData.push(td.innerText);
                        }
                    });
                    data.push(rowData);
                });

                // Tambahkan tabel transaksi ke PDF jika ada data
                if (headers.length > 0 && data.length > 0) {
                    doc.autoTable({
                        head: [headers],
                        body: data,
                        startY: doc.previousAutoTable.finalY + 10,
                        theme: "grid",
                        styles: {
                            fontSize: 10
                        },
                        headStyles: {
                            fillColor: [62, 129, 171]
                        },
                        margin: {
                            top: 15
                        }
                    });
                }
            }

            // Save with formatted filename
            const filename =
                `Laporan_Transaksi_${now.getFullYear()}${String(now.getMonth() + 1).padStart(2, '0')}${String(now.getDate()).padStart(2, '0')}_${String(now.getHours()).padStart(2, '0')}${String(now.getMinutes()).padStart(2, '0')}.pdf`;
            doc.save(filename);
        });

        // Check shift status when page loads to handle server restart case
        document.addEventListener('DOMContentLoaded', function() {
            // Cek apakah sudah ada data shift dari server-side
            const currentShiftElement = document.querySelector('[data-shift-active]');
            if (currentShiftElement) {
                // Gunakan data dari server-side
                const hasActiveShift = currentShiftElement.getAttribute('data-shift-active') === '1';
                updateShiftStatus(hasActiveShift);
                return;
            }

            // Jika tidak ada data dari server-side, baru lakukan fetch
            fetch('{{ route('shift.check') }}')
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.hasActiveShift) {
                        const endShiftButton = document.getElementById('btnEndShift');
                        if (!endShiftButton || endShiftButton.style.display === 'none') {
                            window.location.reload();
                        }
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    // Hanya tampilkan error jika benar-benar gagal fetch
                    if (error.message !== 'Network response was not ok') {
                        showNotification('error', 'Terjadi kesalahan saat memeriksa status shift');
                    }
                });
        });
    </script>
@endsection
