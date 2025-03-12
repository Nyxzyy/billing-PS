@extends('kasir.layout-kasir')

@section('title', 'Dashboard')
@section('breadcrumb', 'Dashboard')

@section('content')
<div class="max-w-screen-xl mx-auto px-2 md:px-2">
    <h1 class="text-xl md:text-3xl font-bold">Dashboard</h1>
    <p class="text-[#414141] mb-8">Lihat ringkasan keuangan dan status perangkat berdasarkan data hari ini.</p>
    
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        <div class="bg-white shadow-md rounded-lg p-4 flex flex-col border-[#C5C5C5]">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-[#565656]">Hari ini,</p>
                    <p class="text-lg md:text-xl font-bold">04 Maret 01:11</p>
                </div>
                <div class="bg-[#3E81AB] text-white p-2 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                </div>
            </div>
            <div class="border-t border-[#DFDFDF] w-full mt-2 pt-2 mb-4"></div>
        </div>                    
        <div class="bg-white shadow-md rounded-lg p-4 flex flex-col border-[#C5C5C5]">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-[#565656]">Device Terisi</p>
                    <p class="text-lg md:text-xl font-bold">38 Device</p>
                </div>
                <div class="bg-[#3E81AB] text-white p-2 rounded-lg ">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="22" y1="12" x2="2" y2="12"></line><path d="M5.45 5.11L2 12v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-6l-3.45-6.89A2 2 0 0 0 16.76 4H7.24a2 2 0 0 0-1.79 1.11z"></path><line x1="6" y1="16" x2="6" y2="16"></line><line x1="10" y1="16" x2="10" y2="16"></line></svg>
                </div>
            </div>
            <div class="border-t border-[#DFDFDF] w-full mt-2 pt-2 mb-4"></div>
        </div>
        <div class="bg-white shadow-md rounded-lg p-4 flex flex-col border-[#C5C5C5]">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-[#565656]">Device Kosong</p>
                    <p class="text-lg md:text-xl font-bold">12 Device</p>
                </div>
                <div class="bg-[#3E81AB] text-white p-2 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="22" y1="12" x2="2" y2="12"></line><path d="M5.45 5.11L2 12v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-6l-3.45-6.89A2 2 0 0 0 16.76 4H7.24a2 2 0 0 0-1.79 1.11z"></path><line x1="6" y1="16" x2="6" y2="16"></line><line x1="10" y1="16" x2="10" y2="16"></line></svg>
                </div>
            </div>
            <div class="border-t border-[#DFDFDF] w-full mt-2 pt-2 mb-4"></div>
        </div>
    </div>
</div>
@endsection
