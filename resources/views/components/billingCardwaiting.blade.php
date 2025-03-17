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
    <div class="flex space-x-2 mt-auto">
        <button onclick="finishBilling('{{ $device->id }}')"
            class="text-xs bg-[#FB2C36] text-white font-extrabold py-2 rounded-lg w-full cursor-pointer">
            SELESAI
        </button>
        <button onclick="restartBilling('{{ $device->id }}')"
            class="text-xs bg-green-500 text-white font-extrabold p-2 rounded-lg cursor-pointer flex items-center justify-center" 
            title="Kembalikan ke status Berjalan">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" 
                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"></path>
                <path d="M3 3v5h5"></path>
            </svg>
        </button>
    </div>
</div>

<script>
    function finishBilling(deviceId) {
        fetch("{{ route('billing.finish') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    device_id: deviceId
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    alert('Billing berhasil diselesaikan!');
                    location.reload();
                } else {
                    alert(data.message || 'Gagal menyelesaikan billing!');
                }
            })
            .catch(error => {
                console.error('Error finishing billing:', error);
                alert('Terjadi kesalahan saat menyelesaikan billing');
            });
    }

    function restartBilling(deviceId) {
        if (confirm('Apakah Anda yakin ingin mengembalikan status device ini menjadi Berjalan?')) {
            fetch("{{ route('billing.restart') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    device_id: deviceId
                })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (data.status === 'success') {
                    alert('Status device berhasil dikembalikan menjadi Berjalan!');
                    location.reload();
                } else {
                    alert(data.message || 'Gagal mengubah status device!');
                    location.reload(); // Reload to ensure UI is in sync with server state
                }
            })
            .catch(error => {
                console.error('Error restarting billing:', error);
                alert('Terjadi kesalahan saat mengubah status device');
                location.reload(); // Reload to ensure UI is in sync with server state
            });
        }
    }
</script>
