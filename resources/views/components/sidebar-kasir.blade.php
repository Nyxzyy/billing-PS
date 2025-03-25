<div id="sidebar"
    class="w-full md:w-1/4 lg:w-1/5 bg-white text-black flex flex-col p-4 min-h-screen fixed md:relative top-0 left-0 h-full md:h-auto z-50 transition-transform duration-300 ease-in-out transform -translate-x-full md:translate-x-0">
    <div class="flex items-center justify-around mb-4 py-2 border-b-2 border-[#F3F3F3]">
        <img src="{{ asset('assets/images/Playstation-Logo-Transparent-Image.png') }}" alt="Logo" class="w-auto max-w-[120px] md:max-w-[150px] lg:max-w-[180px] h-auto object-contain">
        <button class="pl-12 md:hidden text-gray-600 hover:text-black" onclick="toggleSidebar()">
            ✖
        </button>
    </div>
    <nav>
        <ul>
            <li class="mb-4">
                <a href="{{ route('kasir.dashboard') }}"
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
            <li class="mb-4">
                <a href="{{ route('kasir.billing') }}"
                    class="font-medium flex items-center gap-2 p-2 rounded text-black hover:bg-[#3E81AB] hover:text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"></circle>
                        <polyline points="12 6 12 12 16 14"></polyline>
                    </svg>
                    Billing
                </a>
            </li>
            <li class="mb-4">
                <a href="{{ route('kasir.laporan') }}"
                    class="group font-medium flex items-center gap-2 p-2 rounded text-black hover:bg-[#3E81AB] hover:text-white">
                    <img src="{{ asset('assets/icon/report_svgrepo.com.svg') }}" alt="Laporan"
                        class="w-6 h-6 transition duration-200 group-hover:hidden">
                    <img src="{{ asset('assets/icon/report-svgrepo-com 1.svg') }}" alt="Laporan"
                        class="w-6 h-6 transition duration-200 hidden group-hover:block">
                    Laporan
                </a>
            </li>
        </ul>
    </nav>
    <div class="mt-auto mb-4">
        <form id="logout-form" method="POST" action="{{ route('logout') }}" class="hidden">
            @csrf
        </form>
        <button onclick="checkShiftBeforeLogout()"
            class="flex items-center gap-2 w-full text-left p-2 rounded text-black hover:bg-[#3E81AB] hover:text-white hover:cursor-pointer">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M16 17l5-5-5-5M19.8 12H9M13 22a10 10 0 1 1 0-20" />
            </svg>
            Keluar Akun
        </button>
    </div>

</div>

<button class="md:hidden fixed top-1 left-2 text-black p-2 rounded-full z-20" onclick="toggleSidebar()">
    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg>
</button>

<script>
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        sidebar.classList.toggle('-translate-x-full');
    }

    function checkShiftBeforeLogout() {
        fetch('/kasir/shift/check-status')
            .then(response => response.json())
            .then(data => {
                if (data.hasActiveShift) {
                    openModal('modalLogoutConfirm');
                } else {
                    document.getElementById('logout-form').submit();
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('error', 'Terjadi kesalahan saat memeriksa status shift');
            });
    }
</script>
