@extends('admin.layout-admin')

@section('title', 'Laporan Transaksi')
@section('breadcrumb', 'Laporan')

@section('content')
    <div class="max-w-screen-xl mx-auto px-2 md:px-2">
        <h1 class="text-xl md:text-3xl font-bold">Laporan Transaksi</h1>
        <p class="text-[#414141] mb-8">Pantau dan analisis laporan transaksi dibawah ini dengan filter harian, mingguan, dan
            bulanan.</p>

        <div class="relative overflow-x-auto shadow-md sm:rounded-lg bg-white p-6">
            <div class="flex flex-col md:flex-row md:justify-end md:items-center gap-2">
                <!-- Date Range Filters -->
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

                <!-- Existing Search Field -->
                <form action="{{ route('admin.laporanTransaksi') }}" method="GET" class="relative w-full md:w-1/5">
                    <svg class="absolute left-3 top-2.5 w-4 h-4 text-[#6D717F]" xmlns="http://www.w3.org/2000/svg"
                        width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="11" cy="11" r="8"></circle>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                    </svg>
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Ketik untuk mencari di tabel"
                        class="text-[#6D717F] text-sm w-full pl-8 py-2 border border-[#c4c4c4] rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </form>
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
                            <form action="{{ route('admin.laporanTransaksi.download') }}" method="GET">
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
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="p-4">
            <div class="bg-white rounded-lg shadow p-4 mb-4">
                <div class="flex justify-between items-center mb-2">
                    <h2 class="text-lg font-semibold">Informasi Transaksi</h2>
                    <span id="shiftStatus">
                    </span>
                </div>
                <div class="grid grid-cols-2 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-600">Total Transaksi</p>
                        <p class="text-xl font-semibold total-transactions">
                            {{ number_format($totalTransactions, 0, ',', '.') }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Total Pendapatan</p>
                        <p class="text-xl font-semibold total-revenue">Rp
                            {{ number_format($totalRevenue, 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>

            <div id="table-container" class="bg-white rounded-lg shadow overflow-hidden">
                @include('admin.partials.transaction-table', ['transactions' => $transactions])
            </div>
        </div>
    </div>
    </div>
@endsection

@push('scripts')
    <script>
        let searchTimer;
        const searchInput = document.querySelector('input[name="search"]');
        const startDateInput = document.getElementById('start_date');
        const endDateInput = document.getElementById('end_date');

        // Function to update data
        function updateData() {
            const searchTerm = searchInput.value;
            const startDate = startDateInput.value;
            const endDate = endDateInput.value;

            // Show loading state
            document.getElementById('table-container').classList.add('opacity-50');

            fetch(`{{ route('admin.laporanTransaksi') }}?search=${searchTerm}&filter_start_date=${startDate}&filter_end_date=${endDate}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    // Update table content
                    document.getElementById('table-container').innerHTML = data.table;

                    // Update totals
                    document.querySelector('.total-transactions').textContent = data.totalTransactions;
                    document.querySelector('.total-revenue').textContent = data.totalRevenue;

                    // Remove loading state
                    document.getElementById('table-container').classList.remove('opacity-50');

                    // Update URL without page refresh
                    const url = new URL(window.location);
                    url.searchParams.set('search', searchTerm);
                    url.searchParams.set('filter_start_date', startDate);
                    url.searchParams.set('filter_end_date', endDate);
                    window.history.pushState({}, '', url);
                })
                .catch(error => {
                    console.error('Error:', error);
                    document.getElementById('table-container').classList.remove('opacity-50');
                });
        }

        // Event listeners
        searchInput.addEventListener('input', () => {
            clearTimeout(searchTimer);
            searchTimer = setTimeout(updateData, 300);
        });

        startDateInput.addEventListener('change', updateData);
        endDateInput.addEventListener('change', updateData);
    </script>
@endpush
