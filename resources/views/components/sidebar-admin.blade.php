<div id="sidebar"
    class="w-full md:w-1/4 lg:w-1/5 bg-white text-black flex flex-col p-4 h-screen fixed md:relative top-0 left-0 overflow-y-auto z-50 transition-transform duration-300 ease-in-out transform -translate-x-full md:translate-x-0">
    <div class="flex items-center justify-around mb-4 py-2 border-b-2 border-[#F3F3F3]">
        <img src="{{ asset('assets/images/Playstation-Logo-Transparent-Image.png') }}" alt="Logo"
            class="w-auto max-w-[120px] md:max-w-[150px] lg:max-w-[180px] h-auto object-contain">
        <button class="pl-12 md:hidden text-gray-600 hover:text-black" onclick="toggleSidebar()">
            ✖
        </button>
    </div>
    <nav>
        <ul>
            <li class="mb-1">
                <a href="{{ route('admin.dashboard') }}"
                    class="font-medium flex items-center gap-2 p-2 rounded text-black hover:bg-[#3E81AB] hover:text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <rect x="3" y="3" width="7" height="7"></rect>
                        <rect x="14" y="3" width="7" height="7"></rect>
                        <rect x="14" y="14" width="7" height="7"></rect>
                        <rect x="3" y="14" width="7" height="7"></rect>
                    </svg>
                    Dashboard
                </a>
            </li>
            <li class="mb-2">
                <a class="font-medium flex items-center gap-2 p-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"></circle>
                        <polyline points="12 6 12 12 16 14"></polyline>
                    </svg>
                    Management Billing
                </a>
                <ul class="ml-8">
                    <li><a href="{{ route('admin.paketBilling') }}"
                            class="flex items-center gap-2 p-1 rounded text-black hover:bg-[#3E81AB] hover:text-white"><i
                                class="fas fa-file-invoice"></i> Paket Billing</a></li>
                    <li><a href="{{ route('admin.openBilling.index') }}"
                            class="flex items-center gap-2 p-1 rounded text-black hover:bg-[#3E81AB] hover:text-white"><i
                                class="fas fa-folder-open"></i> Open Billing</a></li>
                </ul>
            </li>
            <li class="mb-2">
                <a href="{{ route('admin.managePerangkat') }}"
                    class="group font-medium flex items-center gap-2 p-2 rounded text-black hover:bg-[#3E81AB] hover:text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <line x1="22" y1="12" x2="2" y2="12"></line>
                        <path
                            d="M5.45 5.11L2 12v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-6l-3.45-6.89A2 2 0 0 0 16.76 4H7.24a2 2 0 0 0-1.79 1.11z">
                        </path>
                        <line x1="6" y1="16" x2="6" y2="16"></line>
                        <line x1="10" y1="16" x2="10" y2="16"></line>
                    </svg>
                    Management Perangkat
                </a>
            </li>
            <li class="mb-1">
                <a href="{{ route('admin.manageUser') }}"
                    class="group font-medium flex items-center gap-2 p-2 rounded text-black hover:bg-[#3E81AB] hover:text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                        <circle cx="12" cy="7" r="4"></circle>
                    </svg>
                    Management Users
                </a>
            </li>
            <li class="mb-2">
                <a class="group font-medium flex items-center gap-2 p-2 text-black">
                    <img src="{{ asset('assets/icon/report_svgrepo.com.svg') }}" alt="Laporan" class="w-6 h-6">
                    Laporan
                </a>
                <ul class="ml-8">
                    <li><a href="{{ route('admin.laporanDevice') }}"
                            class="flex items-center gap-2 p-1 rounded hover:bg-[#3E81AB] hover:text-white"><svg
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16c0 1.1.9 2 2 2h12a2 2 0 0 0 2-2V8l-6-6z" />
                                <path d="M14 3v5h5M16 13H8M16 17H8M10 9H8" />
                            </svg> Laporan Device</a></li>
                    <li><a href="{{ route('admin.laporanKasir') }}"
                            class="flex items-center gap-2 p-1 rounded hover:bg-[#3E81AB] hover:text-white"><svg
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16c0 1.1.9 2 2 2h12a2 2 0 0 0 2-2V8l-6-6z" />
                                <path d="M14 3v5h5M16 13H8M16 17H8M10 9H8" />
                            </svg> Laporan Kasir</a></li>
                    <li><a href="{{ route('admin.laporanTransaksi') }}"
                            class="flex items-center gap-2 p-1 rounded hover:bg-[#3E81AB] hover:text-white"><svg
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16c0 1.1.9 2 2 2h12a2 2 0 0 0 2-2V8l-6-6z" />
                                <path d="M14 3v5h5M16 13H8M16 17H8M10 9H8" />
                            </svg> Laporan Transaksi</a></li>
                    <li><a href="{{ route('admin.laporan-kendala') }}"
                            class="flex items-center gap-2 p-1 rounded hover:bg-[#3E81AB] hover:text-white"><svg
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16c0 1.1.9 2 2 2h12a2 2 0 0 0 2-2V8l-6-6z" />
                                <path d="M14 3v5h5M16 13H8M16 17H8M10 9H8" />
                            </svg> Laporan Kendala</a></li>
                </ul>
            </li>
            <li class="mb-2">
                <a href="{{ route('admin.logActivity') }}"
                    class="font-medium flex items-center gap-2 p-2 rounded text-black hover:bg-[#3E81AB] hover:text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z" />
                    </svg>
                    Log Activity
                </a>
            </li>
        </ul>
    </nav>
    <div class="mt-auto mb-4">
        <form id="logout-form" method="POST" action="{{ route('logout') }}">
            @csrf
            <button
                class="flex items-center gap-2 w-full text-left p-2 rounded text-black hover:bg-[#3E81AB] hover:text-white hover:cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round">
                    <path d="M16 17l5-5-5-5M19.8 12H9M13 22a10 10 0 1 1 0-20" />
                </svg>
                Keluar Akun
            </button>
        </form>
    </div>

</div>

<button class="md:hidden fixed top-1 left-2 text-black p-2 rounded-full z-20" onclick="toggleSidebar()">
    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
        stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round">
        <line x1="3" y1="12" x2="21" y2="12"></line>
        <line x1="3" y1="6" x2="21" y2="6"></line>
        <line x1="3" y1="18" x2="21" y2="18"></line>
    </svg>
</button>

<script>
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        sidebar.classList.toggle('-translate-x-full');
    }
</script>
