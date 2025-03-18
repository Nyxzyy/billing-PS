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
                        <p id="currentTime" class="text-lg md:text-xl font-bold"></p>
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
                        <p class="text-lg md:text-xl font-bold">Device</p>
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
                    <p class="text-[#565656] text-sm">Semua perangkat yang terdaftar</p>
                </div>
            </div>

            <div class="bg-white shadow-md rounded-lg p-4 flex flex-col border-[#C5C5C5]">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-[#565656]">Device Terisi</p>
                        <p class="text-lg md:text-xl font-bold">Device</p>
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
                </div>
            </div>

            <div class="bg-white shadow-md rounded-lg p-4 flex flex-col border-[#C5C5C5]">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-[#565656]">Device Kosong</p>
                        <p class="text-lg md:text-xl font-bold">Device</p>
                    </div>
                    <div class="bg-[#3E81AB] text-white p-2 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
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
                </div>
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-8">
            <div class="bg-white shadow-md rounded-lg p-4 col-span-2">
                <div class="flex justify-between items-center mb-2">
                    <div>
                        <h2 class="text-lg font-semibold">Grafik Pemasukan</h2>
                        <p class="text-gray-500 text-sm">Grafik pemasukan dalam seminggu ini.</p>
                    </div>
                    <div class="bg-[#3E81AB] text-white p-2 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" 
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" 
                            stroke-linejoin="round">
                            <path d="M3 3v18h18"/>
                            <path d="M18.7 8l-5.1 5.2-2.8-2.7L7 14.3"/>
                        </svg>
                    </div>
                </div>
                <canvas id="incomeChart" height="200"></canvas>
            </div>

            <div class="grid grid-rows-2 gap-4">
                <div class="bg-white shadow-md rounded-lg p-4">
                    <div class="flex items-start justify-between">
                        <div>
                            <h3 class="text-gray-600">Jumlah Kasir</h3>
                            <p class="text-2xl font-bold">12 Kasir</p>
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
                            <p class="text-2xl font-bold">Rp 325.000,00</p>
                        </div>
                        <div class="bg-[#3E81AB] text-white p-2 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" 
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <line x1="12" y1="1" x2="12" y2="23"></line>
                                <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="border-t border-gray-300 w-full mt-2 pt-2"></div>
                    <div class="mt-2">
                        <p class="text-black text-sm font-bold"><span class="text-green-600 text-sm font-bold">+2% </span>Dari Kemarin</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<script>
    function fetchTime() {
        fetch('/current-time')
            .then(response => response.json())
            .then(data => {
                document.getElementById('currentTime').innerText = data.time;
            });
    }

    setInterval(fetchTime, 1000);
</script>
