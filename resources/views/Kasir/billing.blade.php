@extends('kasir.layout-kasir')

@section('title', 'Billing')
@section('breadcrumb', 'Billing')

@section('content')
    <div class="max-w-screen-xl mx-auto px-2 md:px-2">
        <h1 class="text-xl md:text-3xl font-bold">Billing</h1>
        <p class="text-[#414141] mb-8">Kontrol billing perangkat dengan cepat. Pantau status perangkat aktif dan non-aktif
            dalam satu tampilan.</p>

        <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-6 gap-2">
            @foreach ($devices as $device)
                @if ($device->status == 'Tersedia')
                    @include('components.billingCardavail', ['device' => $device])
                @elseif ($device->status == 'Berjalan')
                    @include('components.billingCardrunning', ['device' => $device])
                @elseif ($device->status == 'Maintenance')
                    @include('components.billingCarderror', ['device' => $device])
                @elseif ($device->status == 'Pending')
                    @include('components.billingCardwaiting', ['device' => $device])
                @endif
            @endforeach
        </div>
    </div>

    @include('components.popup-kasir', ['packages' => $packages])
@endsection
