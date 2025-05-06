<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body style="background-color: #F5F5F5" class="overflow-hidden">
    <div class="flex flex-col md:flex-row h-screen">
        @include('components.sidebar-kasir')
        <!-- Ubah div content -->
        <div class="w-full md:w-full h-screen overflow-y-auto" id="content-area">
            <div class="w-full bg-gray-100 py-3 mb-4 flex flex-wrap justify-between items-center px-4 md:px-6">
                <div class="text-lg md:text-2xl text-gray-500">
                    Pages / <span id="breadcrumb" class="font-normal text-black">@yield('breadcrumb')</span>
                </div>
                <div class="flex items-center text-black mt-2 md:mt-0">
                    {{ Auth::user()->name ?? 'Guest' }}
                    <span class="ml-2">
                        <svg onclick="openModal('modalMulaiShift')" xmlns="http://www.w3.org/2000/svg" width="24"
                            height="24" viewBox="0 0 24 24" fill="none" stroke="#818181" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path d="M5.52 19c.64-2.2 1.84-3 3.22-3h6.52c1.38 0 2.58.8 3.22 3" />
                            <circle cx="12" cy="10" r="3" />
                            <circle cx="12" cy="12" r="10" />
                        </svg>
                    </span>
                </div>
            </div>
            <div class="p-4 max-w-screen-xl mx-auto">
                @yield('content')
            </div>
        </div>
    </div>

    @include('components.popup-kasir')

    <script>
        function showNotification(type, message) {
            // You can implement this based on your notification system
            alert(message);
        }

        function openModal(modalId) {
            document.getElementById(modalId).classList.remove('invisible');
        }

        function closeModal(modalId) {
            document.getElementById(modalId).classList.add('invisible');
        }

        function checkShiftStatus() {
            fetch('/shift/check')
                .then(response => response.json())
                .then(data => {
                    // Jika tidak ada shift aktif, tampilkan modal mulai shift
                    if (!data.hasActiveShift) {
                        openModal('modalMulaiShift');
                    } else {
                        // Update UI untuk menampilkan info shift aktif
                        updateShiftInfo(data.shiftData);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }

        function updateShiftInfo(shiftData) {
            // Tampilkan tombol Tutup Buku jika ada shift aktif
            const endShiftButton = document.querySelector('[onclick="endShift()"]');
            if (endShiftButton) {
                endShiftButton.style.display = 'flex';
            }
        }

        function startShift() {
            fetch('/shift/start', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        closeModal('modalMulaiShift');
                        showNotification('success', data.message);
                        // Reload halaman untuk memperbarui UI
                        window.location.reload();
                    } else {
                        showNotification('error', data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showNotification('error', 'Terjadi kesalahan saat memulai shift');
                });
        }

        function closeShiftModal() {
            closeModal('modalMulaiShift');
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Check shift status on every page load
            checkShiftStatus();
        });
    </script>

    @stack('scripts')
</body>

</html>
