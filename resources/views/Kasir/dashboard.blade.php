@extends('kasir.layout-kasir')

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
                        <p id="currentTime" class="text-lg md:text-xl font-bold">{{ $today }}</p>
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
                        <p class="text-lg md:text-xl font-bold">{{ $totalDevices }} Device</p>
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
                        <p class="text-lg md:text-xl font-bold">{{ $runningDevices }} Device</p>
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
                        <p class="text-lg md:text-xl font-bold">{{ $availableDevices }} Device</p>
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
                </div>
            </div>
        </div>

        <!-- Additional Statistics -->
        <div class="mt-8 grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div class="bg-white shadow-md rounded-lg p-4">
                <h2 class="text-lg font-bold mb-4">Status Device</h2>
                <div class="space-y-4">
                    <div class="flex justify-between items-center">
                        <span class="text-[#565656]">Berjalan</span>
                        <div class="flex items-center">
                            <span class="text-[#3E81AB] font-bold">{{ $runningDevices }}</span>
                            <div class="w-2 h-2 rounded-full bg-[#3E81AB] ml-2"></div>
                        </div>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-[#565656]">Tersedia</span>
                        <div class="flex items-center">
                            <span class="text-[#34D399] font-bold">{{ $availableDevices }}</span>
                            <div class="w-2 h-2 rounded-full bg-[#34D399] ml-2"></div>
                        </div>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-[#565656]">Maintenance</span>
                        <div class="flex items-center">
                            <span class="text-[#FB923C] font-bold">{{ $maintenanceDevices }}</span>
                            <div class="w-2 h-2 rounded-full bg-[#FB923C] ml-2"></div>
                        </div>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-[#565656]">Pending</span>
                        <div class="flex items-center">
                            <span class="text-[#F87171] font-bold">{{ $pendingDevices }}</span>
                            <div class="w-2 h-2 rounded-full bg-[#F87171] ml-2"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white shadow-md rounded-lg p-4">
                <h2 class="text-lg font-bold mb-4">Persentase Penggunaan</h2>
                <div class="flex items-center justify-center h-48">
                    <div class="text-center">
                        <div class="text-3xl font-bold text-[#3E81AB]">
                            {{ $totalDevices > 0 ? round(($runningDevices / $totalDevices) * 100) : 0 }}%
                        </div>
                        <p class="text-[#565656] mt-2">Device Terisi</p>
                    </div>
                    <div class="border-r border-[#DFDFDF] h-16 mx-8"></div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-[#34D399]">
                            {{ $totalDevices > 0 ? round(($availableDevices / $totalDevices) * 100) : 0 }}%
                        </div>
                        <p class="text-[#565656] mt-2">Device Kosong</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<script></script>
