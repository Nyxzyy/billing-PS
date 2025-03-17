@php
    // Jika device tidak diteruskan, gunakan default
    $device = $device ?? null;
    $shutdown_time = $device->shutdown_time ? \Carbon\Carbon::parse($device->shutdown_time)->format('Y-m-d H:i:s') : null;
@endphp
<div class="relative bg-white shadow-md rounded-lg p-4 flex flex-col billing-card-pending" data-device-id="{{ $device->id }}" data-shutdown-time="{{ $shutdown_time }}">
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
        <button onclick="updateDeviceStatus('{{ $device->id }}', 'Berjalan')"
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
        if (!confirm('Apakah Anda yakin ingin menyelesaikan billing ini?')) {
            return;
        }

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
                    let message = 'Billing berhasil diselesaikan!';
                    
                    // If transaction data is available (especially for Open Billing)
                    if (data.transaction) {
                        const startTime = new Date(data.transaction.start_time);
                        const endTime = new Date(data.transaction.end_time);
                        const duration = data.transaction.duration;
                        const totalPrice = data.transaction.total_price;
                        
                        // Format times
                        const formatTime = (date) => {
                            return date.toLocaleTimeString('id-ID', { 
                                hour: '2-digit', 
                                minute: '2-digit'
                            });
                        };
                        
                        // Format duration
                        const hours = Math.floor(duration / 60);
                        const minutes = duration % 60;
                        const durationStr = hours > 0 
                            ? `${hours} jam ${minutes} menit`
                            : `${minutes} menit`;
                        
                        // Format price
                        const formattedPrice = new Intl.NumberFormat('id-ID', {
                            style: 'currency',
                            currency: 'IDR',
                            minimumFractionDigits: 0,
                            maximumFractionDigits: 0
                        }).format(totalPrice);
                        
                        message = `Billing selesai!\n\n` +
                                 `Mulai: ${formatTime(startTime)}\n` +
                                 `Selesai: ${formatTime(endTime)}\n` +
                                 `Durasi: ${durationStr}\n` +
                                 `Total: ${formattedPrice}`;
                    }
                    
                    alert(message);
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

    function updateDeviceStatus(deviceId, status) {
        if (confirm('Apakah Anda yakin ingin mengubah status device ini menjadi ' + status + '?')) {
            fetch("{{ route('billing.restart') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    device_id: deviceId,
                    status: status
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
                    alert('Status device berhasil diubah menjadi ' + status + '!');
                    location.reload();
                } else {
                    alert(data.message || 'Gagal mengubah status device!');
                    location.reload(); // Reload to ensure UI is in sync with server state
                }
            })
            .catch(error => {
                console.error('Error updating device status:', error);
                alert('Terjadi kesalahan saat mengubah status device');
                location.reload(); // Reload to ensure UI is in sync with server state
            });
        }
    }
</script>
