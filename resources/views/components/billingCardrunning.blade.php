@php
    $device = $device ?? null;
    $shutdown_time = $device->shutdown_time ? \Carbon\Carbon::parse($device->shutdown_time)->format('Y-m-d H:i:s') : null;
    $formatted_time = $device->shutdown_time ? \Carbon\Carbon::parse($device->shutdown_time)->format('H:i') : 'Open Billing';
    $start_time = $device->last_used_at ? \Carbon\Carbon::parse($device->last_used_at)->format('Y-m-d H:i:s') : now()->format('Y-m-d H:i:s');
@endphp

<div class="relative bg-white shadow-md rounded-lg p-4 flex flex-col billing-card-running" 
     data-device-id="{{ $device->id }}"
     data-shutdown-time="{{ $shutdown_time }}"
     data-status="{{ $device->status }}"
     id="device-card-{{ $device->id }}">
    <div class="absolute left-0 top-0 h-full w-2 bg-[#3E81AB] rounded-l-lg"></div>
    <div class="pl-2">
        <h2 class="text-[#3E81AB] font-bold text-sm">{{ $device->name ?? 'Tidak Ditemukan' }}</h2>
        <p class="text-[#6F6F6F] text-xs">{{ $device->location ?? 'Tidak Ditemukan' }}</p>
        <p class="text-[#3E81AB] font-bold text-xs mt-2">Sedang Berjalan</p>
        <p class="text-[#3E81AB] font-bold text-sm mb-2">
            Selesai: <span class="device-time">{{ $formatted_time }}</span>
        </p>
    </div>
    <button
        class="text-xs mt-auto bg-[#3E81AB] text-white font-extrabold py-2 rounded-lg w-full cursor-pointer btn-detail-billing"
        onclick="openModalDetailPaket('{{ $device->id }}', '{{ $device->name }}', '{{ $formatted_time }}', '{{ $device->package }}', '{{ $shutdown_time }}', '{{ $device->last_used_at }}')" 
        data-device-id="{{ $device->id }}"
        data-start-time="{{ $start_time }}">
        DETAIL
    </button>
</div>
