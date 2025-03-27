@extends('admin.layout-admin')

@section('title', 'Dashboard')
@section('breadcrumb', 'Dashboard')

@section('content')
    <div class="max-w-screen-xl mx-auto px-2 md:px-2">
        <h1 class="text-xl md:text-3xl font-bold">Dashboard</h1>
        <p class="text-[#414141] mb-8">Lihat ringkasan keuangan dan status perangkat berdasarkan data hari ini.</p>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="bg-white shadow-md rounded-lg p-4 flex flex-col border-[#C5C5C5]">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-[#565656]">Hari ini,</p>
                        <p id="currentDate" class="text-lg md:text-xl font-bold"></p>
                        <p id="currentTime" class="text-sm text-gray-500"></p>
                    </div>
                    <div class="bg-[#3E81AB] text-white p-2 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                            <line x1="16" y1="2" x2="16" y2="6"></line>
                            <line x1="8" y1="2" x2="8" y2="6"></line>
                            <line x1="3" y1="10" x2="21" y2="10"></line>
                        </svg>
                    </div>
                </div>
                <div class="border-t border-[#DFDFDF] w-full mt-2 pt-2 mb-4"></div>
            </div>

            <div class="bg-white shadow-md rounded-lg p-4 flex flex-col border-[#C5C5C5]">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-[#565656]">Total Device</p>
                        <p class="text-lg md:text-xl font-bold" id="totalDevices">{{ $totalDevices }}</p>
                    </div>
                    <div class="bg-[#3E81AB] text-white p-2 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect>
                            <line x1="8" y1="21" x2="16" y2="21"></line>
                            <line x1="12" y1="17" x2="12" y2="21"></line>
                        </svg>
                    </div>
                </div>
                <div class="border-t border-[#DFDFDF] w-full mt-2 pt-2"></div>
                <div class="mt-2">
                    <p class="text-[#565656] text-sm">Status perangkat saat ini</p>
                    <div class="mt-2 space-y-2">
                        @foreach ($deviceStats as $stat)
                            <div class="flex justify-between text-sm items-center">
                                <span class="flex items-center">
                                    <span class="w-2 h-2 rounded-full bg-{{ $stat['color'] }} mr-2"></span>
                                    {{ $stat['status'] }}
                                </span>
                                <span>{{ $stat['total'] }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="bg-white shadow-md rounded-lg p-4 flex flex-col border-[#C5C5C5]">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-[#565656]">Device Aktif</p>
                        <p class="text-lg md:text-xl font-bold" id="usedDevices">{{ $usedDevices }}</p>
                    </div>
                    <div class="bg-[#3E81AB] text-white p-2 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect>
                            <path d="M8 21h8"></path>
                            <path d="M12 17v4"></path>
                            <circle cx="12" cy="10" r="3"></circle>
                        </svg>
                    </div>
                </div>
                <div class="border-t border-[#DFDFDF] w-full mt-2 pt-2"></div>
                <div class="mt-2">
                    <p class="text-[#565656] text-sm">Device yang sedang digunakan</p>
                    <div class="mt-2">
                        <div class="w-full bg-gray-200 rounded-full h-2.5">
                            <div class="bg-blue-500 h-2.5 rounded-full"
                                style="width: {{ ($usedDevices / $totalDevices) * 100 }}%"></div>
                        </div>
                        <p class="text-sm text-gray-500 mt-1">{{ number_format(($usedDevices / $totalDevices) * 100, 1) }}%
                            dari total device</p>
                    </div>
                </div>
            </div>

            <div class="bg-white shadow-md rounded-lg p-4 flex flex-col border-[#C5C5C5]">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-[#565656]">Device Tersedia</p>
                        <p class="text-lg md:text-xl font-bold" id="availableDevices">{{ $availableDevices }}</p>
                    </div>
                    <div class="bg-[#3E81AB] text-white p-2 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect>
                            <path d="M8 21h8"></path>
                            <path d="M12 17v4"></path>
                            <path d="M6 8h12"></path>
                        </svg>
                    </div>
                </div>
                <div class="border-t border-[#DFDFDF] w-full mt-2 pt-2"></div>
                <div class="mt-2">
                    <p class="text-[#565656] text-sm">Device yang siap digunakan</p>
                    <div class="mt-2">
                        <div class="w-full bg-gray-200 rounded-full h-2.5">
                            <div class="bg-green-500 h-2.5 rounded-full"
                                style="width: {{ ($availableDevices / $totalDevices) * 100 }}%"></div>
                        </div>
                        <p class="text-sm text-gray-500 mt-1">
                            {{ number_format(($availableDevices / $totalDevices) * 100, 1) }}% dari total device</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-8">
            <div class="bg-white shadow-md rounded-lg p-4 col-span-2">
                <div class="flex justify-between items-center mb-4">
                    <div>
                        <h2 class="text-lg font-semibold">Grafik Pemasukan</h2>
                        <p class="text-gray-500 text-sm">Grafik pemasukan berdasarkan periode yang dipilih.</p>
                    </div>
                    <div class="flex items-center space-x-2">
                        <select id="periodFilter"
                            class="bg-white border border-gray-300 text-gray-700 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2">
                            <option value="day">Hari Ini</option>
                            <option value="week" selected>Minggu Ini</option>
                            <option value="month">Bulan Ini</option>
                            <option value="year">Tahun Ini</option>
                            {{-- <option value="custom">Kustom</option> --}}
                        </select>
                        <div id="dateRangeContainer" class="hidden space-x-2 items-center">
                            <input type="date" id="startDate"
                                class="bg-white border border-gray-300 text-gray-700 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2">
                            <span class="text-gray-500">-</span>
                            <input type="date" id="endDate"
                                class="bg-white border border-gray-300 text-gray-700 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2">
                        </div>
                    </div>
                </div>
                <canvas id="incomeChart" height="200"></canvas>
            </div>

            <div class="grid grid-rows-2 gap-4">
                <div class="bg-white shadow-md rounded-lg p-4">
                    <div class="flex items-start justify-between">
                        <div>
                            <h3 class="text-gray-600">Jumlah Kasir</h3>
                            <p class="text-2xl font-bold">{{ $totalCashiers }} Kasir</p>
                        </div>
                        <div class="bg-[#3E81AB] text-white p-2 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M5.52 19c.64-2.2 1.84-3 3.22-3h6.52c1.38 0 2.58.8 3.22 3" />
                                <circle cx="12" cy="10" r="3" />
                                <circle cx="12" cy="12" r="10" />
                            </svg>
                        </div>
                    </div>
                    <div class="border-t border-gray-300 w-full mt-2 pt-2"></div>
                </div>

                <div class="bg-white shadow-md rounded-lg p-4">
                    <div class="flex items-start justify-between">
                        <div>
                            <h3 class="text-gray-600">Pemasukan Hari Ini</h3>
                            <p class="text-2xl font-bold" id="todayIncome">Rp
                                {{ number_format($totalTodayIncome, 0, ',', '.') }}</p>
                        </div>
                        <div class="bg-[#3E81AB] text-white p-2 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <line x1="12" y1="1" x2="12" y2="23"></line>
                                <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="border-t border-gray-300 w-full mt-2 pt-2"></div>
                    <div class="mt-2">
                        <p class="text-black text-sm font-bold">
                            <span class="text-{{ $percentageChange >= 0 ? 'green' : 'red' }}-600 text-sm font-bold">
                                {{ $percentageChange >= 0 ? '+' : '' }}{{ number_format($percentageChange, 1) }}%
                            </span>
                            Dari Kemarin
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Update time function
        function updateTime() {
            fetch('/admin/current-time')
                .then(response => response.json())
                .then(data => {
                    document.getElementById('currentTime').innerText = data.time;
                    document.getElementById('currentDate').innerText = data.date;
                });
        }

        // Update dashboard stats
        function updateStats() {
            fetch('/admin/dashboard-stats')
                .then(response => response.json())
                .then(data => {
                    document.getElementById('totalDevices').innerText = data.devices.total;
                    document.getElementById('usedDevices').innerText = data.devices.used;
                    document.getElementById('availableDevices').innerText = data.devices.available;
                    document.getElementById('todayIncome').innerText = 'Rp ' + new Intl.NumberFormat('id-ID').format(
                        data.income.today);
                });
        }

        // Initialize income chart
        let incomeChart;
        const ctx = document.getElementById('incomeChart').getContext('2d');
        const chartData = @json($chartData);

        function initChart(data) {
            if (incomeChart) {
                incomeChart.destroy();
            }

            incomeChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: data.labels,
                    datasets: [{
                        label: 'Pemasukan',
                        data: data.data,
                        borderColor: '#3E81AB',
                        tension: 0.4,
                        fill: true,
                        backgroundColor: 'rgba(62, 129, 171, 0.1)'
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const value = context.raw;
                                    return [
                                        'Pemasukan: Rp ' + new Intl.NumberFormat('id-ID').format(value),
                                        'Transaksi: ' + data.transactions[context.dataIndex]
                                    ];
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return 'Rp ' + new Intl.NumberFormat('id-ID').format(value);
                                }
                            }
                        }
                    }
                }
            });
        }

        // Update chart data based on filter
        function updateChartData() {
            const period = document.getElementById('periodFilter').value;
            const startDate = document.getElementById('startDate').value;
            const endDate = document.getElementById('endDate').value;

            const formData = new FormData();
            formData.append('period', period);
            if (period === 'custom') {
                formData.append('startDate', startDate);
                formData.append('endDate', endDate);
            }

            fetch('/admin/chart-data', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    initChart(data);
                });
        }

        // Event listeners
        document.getElementById('periodFilter').addEventListener('change', function(e) {
            const dateRangeContainer = document.getElementById('dateRangeContainer');
            if (e.target.value === 'custom') {
                dateRangeContainer.classList.remove('hidden');
            } else {
                dateRangeContainer.classList.add('hidden');
                updateChartData();
            }
        });

        document.getElementById('startDate').addEventListener('change', updateChartData);
        document.getElementById('endDate').addEventListener('change', updateChartData);

        // Update time every second
        setInterval(updateTime, 1000);

        // Update stats every 30 seconds
        setInterval(updateStats, 30000);

        // Initial calls
        updateTime();
        updateStats();
        initChart(chartData);
    </script>
@endpush
