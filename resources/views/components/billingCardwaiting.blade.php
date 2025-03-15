@php
    // Jika device tidak diteruskan, gunakan default
    $device = $device ?? null;
@endphp
<div class="relative bg-white shadow-md rounded-lg p-4 flex flex-col">
    <div class="absolute left-0 top-0 h-full w-2 bg-[#FB2C36] rounded-l-lg"></div>
    <div class="pl-2">
        <h2 class="text-[#FB2C36] font-bold text-sm">{{ $device->name ?? 'Tidak Ditemukan' }}</h2>
        <p class="text-[#6F6F6F] text-xs">{{ $device->location ?? 'Tidak Ditemukan' }}</p>
        <p class="text-[#FB2C36] font-bold text-xs mt-2">Menunggu Konfirmasi</p>
    </div>
    <button class="text-xs mt-auto bg-[#FB2C36] text-white font-extrabold py-2 rounded-lg w-full">
        SELESAI
    </button>
    <div class="absolute top-4 right-4 text-[#FB2C36]">
        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="13" viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M4 15s1-1 4-1 5 2 8 2 4-1 4-1V3s-1 1-4 1-5-2-8-2-4 1-4 1z"></path>
            <line x1="4" y1="22" x2="4" y2="15"></line>
        </svg>
    </div>
</div>
