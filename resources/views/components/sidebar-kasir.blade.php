<div id="sidebar"
    class="w-full md:w-1/4 lg:w-1/5 bg-white text-black flex flex-col p-4 min-h-screen fixed md:relative top-0 left-0 h-full md:h-auto z-50 transition-transform duration-300 ease-in-out transform -translate-x-full md:translate-x-0">
    <div class="flex items-center justify-around mb-6 py-4 border-b-2 border-[#F3F3F3]">
        <h1 class="text-2xl md:text-3xl font-bold italic text-center">INILOGONYA</h1>
        <button class="pl-12 md:hidden text-gray-600 hover:text-black" onclick="toggleSidebar()">
            ✖
        </button>
    </div>
    <nav>
        <ul>
            <li class="mb-4">
                <a href="{{ route('kasir.dashboard') }}"
                    class="text-lg md:text-xl font-medium flex items-center gap-2 p-2 rounded text-black hover:bg-[#3E81AB] hover:text-white">
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
                    class="text-lg md:text-xl font-medium flex items-center gap-2 p-2 rounded text-black hover:bg-[#3E81AB] hover:text-white">
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
                    class="text-lg md:text-xl font-medium block p-2 rounded text-black hover:bg-[#3E81AB] hover:text-white">
                    Laporan
                </a>
            </li>
        </ul>
    </nav>
    <div class="mt-auto">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                class="flex items-center gap-2 w-full text-left p-2 rounded text-black hover:bg-[#3E81AB] hover:text-white hover:cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M16 17l5-5-5-5M19.8 12H9M13 22a10 10 0 1 1 0-20" />
                </svg>
                Keluar Akun
            </button>
        </form>
    </div>

</div>

<button class="md:hidden fixed top-2 left-2 text-black p-2 rounded-full" onclick="toggleSidebar()">
    ☰
</button>

<script>
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        sidebar.classList.toggle('-translate-x-full');
    }
</script>
