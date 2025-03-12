@extends('kasir.layout-kasir')

@section('title', 'Billing')
@section('breadcrumb', 'Billing')

@section('content')
<div class="max-w-screen-xl mx-auto px-2 md:px-2">
    <h1 class="text-xl md:text-3xl font-bold">Billing</h1>
    <p class="text-[#414141] mb-8">Kontrol billing perangkat dengan cepat. Pantau status perangkat aktif dan non-aktif dalam satu tampilan.</p>

    <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-6 gap-2">
        <div class="relative bg-white shadow-md rounded-lg p-4 flex flex-col">
            <div class="absolute left-0 top-0 h-full w-2 bg-[#A8A8A8] rounded-l-lg"></div>
            <div class="pl-2">
                <h2 class="text-[#A8A8A8] font-bold text-sm">PS 02</h2>
                <p class="text-[#CDCDCD] text-xs">Ruangan 1 - Lantai 1</p>
                <p class="text-[#A8A8A8] font-bold text-xs mt-2 mb-4">Terkendala</p>
            </div>
            <button class="text-xs mt-auto bg-[#A8A8A8] text-white font-extrabold py-2 rounded-lg w-full">
                MULAI
            </button>
            <div class="absolute top-4 right-4 text-[#FB2C36]">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 15s1-1 4-1 5 2 8 2 4-1 4-1V3s-1 1-4 1-5-2-8-2-4 1-4 1z"></path><line x1="4" y1="22" x2="4" y2="15"></line></svg>
            </div>
        </div>
        <div class="relative bg-white shadow-md rounded-lg p-4 flex flex-col">
            <div class="absolute left-0 top-0 h-full w-2 bg-[#364153] rounded-l-lg"></div>
            <div class="pl-2">
                <h2 class="text-[#364153] font-bold text-sm">PS 02</h2>
                <p class="text-[#6F6F6F] text-xs">Ruangan 1 - Lantai 1</p>
                <p class="text-[#364153] font-bold text-xs mt-2 mb-4">Tersedia</p>
            </div>
            <button class="text-xs mt-auto bg-[#364153] text-white font-extrabold py-2 rounded-lg w-full">
                MULAI
            </button>
            <div class="absolute top-4 right-4 text-[#FB2C36]">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 15s1-1 4-1 5 2 8 2 4-1 4-1V3s-1 1-4 1-5-2-8-2-4 1-4 1z"></path><line x1="4" y1="22" x2="4" y2="15"></line></svg>
            </div>
        </div>
        <div class="relative bg-white shadow-md rounded-lg p-4 flex flex-col">
            <div class="absolute left-0 top-0 h-full w-2 bg-[#364153] rounded-l-lg"></div>
            <div class="pl-2">
                <h2 class="text-[#364153] font-bold text-sm">PS 02</h2>
                <p class="text-[#6F6F6F] text-xs">Ruangan 1 - Lantai 1</p>
                <p class="text-[#364153] font-bold text-xs mt-2 mb-4">Tersedia</p>
            </div>
            <button class="text-xs mt-auto bg-[#364153] text-white font-extrabold py-2 rounded-lg w-full">
                MULAI
            </button>
            <div class="absolute top-4 right-4 text-[#FB2C36]">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 15s1-1 4-1 5 2 8 2 4-1 4-1V3s-1 1-4 1-5-2-8-2-4 1-4 1z"></path><line x1="4" y1="22" x2="4" y2="15"></line></svg>
            </div>
        </div>
        <div class="relative bg-white shadow-md rounded-lg p-4 flex flex-col">
            <div class="absolute left-0 top-0 h-full w-2 bg-[#364153] rounded-l-lg"></div>
            <div class="pl-2">
                <h2 class="text-[#364153] font-bold text-sm">PS 02</h2>
                <p class="text-[#6F6F6F] text-xs">Ruangan 1 - Lantai 1</p>
                <p class="text-[#364153] font-bold text-xs mt-2 mb-4">Tersedia</p>
            </div>
            <button class="text-xs mt-auto bg-[#364153] text-white font-extrabold py-2 rounded-lg w-full">
                MULAI
            </button>
            <div class="absolute top-4 right-4 text-[#FB2C36]">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 15s1-1 4-1 5 2 8 2 4-1 4-1V3s-1 1-4 1-5-2-8-2-4 1-4 1z"></path><line x1="4" y1="22" x2="4" y2="15"></line></svg>
            </div>
        </div>
        <div class="relative bg-white shadow-md rounded-lg p-4 flex flex-col">
            <div class="absolute left-0 top-0 h-full w-2 bg-[#364153] rounded-l-lg"></div>
            <div class="pl-2">
                <h2 class="text-[#364153] font-bold text-sm">PS 02</h2>
                <p class="text-[#6F6F6F] text-xs">Ruangan 1 - Lantai 1</p>
                <p class="text-[#364153] font-bold text-xs mt-2 mb-4">Tersedia</p>
            </div>
            <button class="text-xs mt-auto bg-[#364153] text-white font-extrabold py-2 rounded-lg w-full">
                MULAI
            </button>
            <div class="absolute top-4 right-4 text-[#FB2C36]">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 15s1-1 4-1 5 2 8 2 4-1 4-1V3s-1 1-4 1-5-2-8-2-4 1-4 1z"></path><line x1="4" y1="22" x2="4" y2="15"></line></svg>
            </div>
        </div>
        <div class="relative bg-white shadow-md rounded-lg p-4 flex flex-col">
            <div class="absolute left-0 top-0 h-full w-2 bg-[#3E81AB] rounded-l-lg"></div>
            <div class="pl-2">
                <h2 class="text-[#3E81AB] font-bold text-sm">PS 01</h2>
                <p class="text-[#6F6F6F] text-xs">Ruangan 1 - Lantai 1</p>
                <p class="text-[#3E81AB] font-bold text-xs mt-2">Sedang Berjalan</p>
                <p class="text-[#3E81AB] font-bold text-sm mb-2">00:00:00</p>
            </div>
            <button class="text-xs mt-auto bg-[#3E81AB] text-white font-extrabold py-2 rounded-lg w-full">
                EDIT
            </button>
            <div class="absolute top-4 right-4 text-[#FB2C36]">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 15s1-1 4-1 5 2 8 2 4-1 4-1V3s-1 1-4 1-5-2-8-2-4 1-4 1z"></path><line x1="4" y1="22" x2="4" y2="15"></line></svg>
            </div>
        </div>
    </div>
</div>
@endsection
