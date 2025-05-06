@extends('admin.layout-admin')

@section('title', 'Management Perangkat')
@section('breadcrumb', 'Management Perangkat')

@section('content')
    <div class="max-w-screen-xl mx-auto px-2 md:px-2">
        <h1 class="text-xl md:text-3xl font-bold">Management Perangkat</h1>
        <p class="text-[#414141] mb-8">Kelola dan atur perangkat dengan menambahkan nama, lokasi, dan IP address.</p>

        <div class="relative overflow-x-auto shadow-md sm:rounded-lg bg-white p-6">
            <div class="flex flex-col md:flex-row md:justify-end md:items-center gap-2">
                <div class="relative w-full md:w-1/5">
                    <svg class="absolute left-3 top-2.5 w-4 h-4 text-[#6D717F]" xmlns="http://www.w3.org/2000/svg"
                        width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="11" cy="11" r="8"></circle>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                    </svg>
                    <input type="text" name="searchDevices" id="searchDevices" placeholder="Ketik untuk mencari"
                        class="text-[#6D717F] text-sm w-full pl-8 py-2 border border-[#c4c4c4] rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <button onclick="openModal('modalAddPerangkat')"
                    class="bg-[#3E81AB] text-white px-4 py-1.5 rounded text-sm flex items-center gap-2 hover:bg-[#2C5F7C] cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="12" y1="8" x2="12" y2="16"></line>
                        <line x1="8" y1="12" x2="16" y2="12"></line>
                    </svg>
                    Tambah Perangkat
                </button>
            </div>
            <div class="p-4">
                {{-- @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4"
                        role="alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif --}}
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <div class="overflow-x-auto">
                        <div id="deviceTable">
                            @include('admin.partials.managePerangkat-table', ['devices' => $devices])
                        </div>
                    </div>
                </div>
                <div class="flex items-center justify-between mt-4 text-sm text-gray-600">
                    <p>Showing {{ $devices->firstItem() ?? 0 }} - {{ $devices->lastItem() ?? 0 }} of
                        {{ $devices->total() ?? 0 }}</p>
                    <div class="flex space-x-2">
                        {{ $devices->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {
        $('#searchDevices').on('keyup', function() {
            let query = $(this).val();
            $.ajax({
                url: "{{ route('admin.device.search') }}",
                type: "GET",
                data: {
                    query: query
                },
                success: function(response) {
                    $('#deviceTable').html(response.html);
                }
            });
        });
    });
</script>
