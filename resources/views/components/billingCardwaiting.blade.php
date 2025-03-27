@php
    // Jika device tidak diteruskan, gunakan default
    $device = $device ?? null;
    $shutdown_time = $device->shutdown_time
        ? \Carbon\Carbon::parse($device->shutdown_time)->format('Y-m-d H:i:s')
        : null;
@endphp
<div class="relative bg-white shadow-md rounded-lg p-4 flex flex-col billing-card-pending"
    data-device-id="{{ $device->id }}" data-shutdown-time="{{ $shutdown_time }}">
    <div class="absolute left-0 top-0 h-full w-2 bg-[#FB2C36] rounded-l-lg"></div>
    <div class="pl-2">
        <h2 class="text-[#FB2C36] font-bold text-sm">{{ $device->name ?? 'Tidak Ditemukan' }}</h2>
        <p class="text-[#6F6F6F] text-xs">{{ $device->location ?? 'Tidak Ditemukan' }}</p>
        <p class="text-[#FB2C36] font-bold text-xs mt-2">Menunggu Konfirmasi</p>
    </div>
    <div class="flex space-x-2 mt-auto">
        <button onclick="finishBilling('{{ $device->id }}')" id="finish-btn-{{ $device->id }}"
            class="text-xs bg-[#FB2C36] text-white font-extrabold py-2 rounded-lg w-full cursor-pointer">
            SELESAI
        </button>
        <button onclick="updateDeviceStatus('{{ $device->id }}', 'Berjalan')"
            class="text-xs bg-green-500 text-white font-extrabold p-2 rounded-lg cursor-pointer flex items-center justify-center"
            title="Kembalikan ke status Berjalan">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"></path>
                <path d="M3 3v5h5"></path>
            </svg>
        </button>
    </div>
</div>

<script>
    // Fungsi untuk memanggil finishBilling (tanpa konfirmasi)
    function autoFinishBilling(deviceId) {
        fetch("{{ route('billing.finish') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    device_id: deviceId
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    alert('Billing selesai secara otomatis karena waktu paket habis.');
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                } else {
                    alert(data.message || 'Terjadi kesalahan saat menyelesaikan billing');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat menyelesaikan billing. Silakan coba lagi.');
            });
    }

    // Fungsi finishBilling (menggunakan konfirmasi untuk finish manual)
    function finishBilling(deviceId) {
        if (!confirm('Apakah anda yakin ingin menyelesaikan billing ini?')) {
            return;
        }

        fetch("{{ route('billing.finish') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    device_id: deviceId
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    if (data.transaction && data.transaction.id) {
                        const receiptUrl = `{{ route('print.receipt', ['transactionId' => ':id']) }}`.replace(':id',
                            data.transaction.id);
                        const receiptWindow = window.open(
                            receiptUrl,
                            `receipt_${data.transaction.id}`,
                            'width=400,height=600,menubar=no,toolbar=no,location=no,status=no'
                        );

                        if (receiptWindow) {
                            receiptWindow.focus();
                        } else {
                            alert('Popup untuk struk diblokir. Mohon izinkan popup untuk mencetak struk.');
                        }
                    }

                    let message = 'Billing berhasil diselesaikan!';
                    if (data.transaction) {
                        const formattedPrice = new Intl.NumberFormat('id-ID').format(data.transaction.total_price);
                        message += `\nDurasi: ${data.transaction.duration} menit`;
                        message += `\nTotal: Rp ${formattedPrice}`;
                    }
                    alert(message);
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                } else {
                    alert(data.message || 'Terjadi kesalahan saat menyelesaikan billing');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat menyelesaikan billing. Silakan coba lagi.');
            });
    }

    function updateDeviceStatus(deviceId, status) {
        if (confirm('Apakah Anda yakin ingin mengubah status device ini menjadi ' + status + '?')) {
            fetch("{{ route('billing.restart') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
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
                        location.reload();
                    }
                })
                .catch(error => {
                    console.error('Error updating device status:', error);
                    alert('Terjadi kesalahan saat mengubah status device');
                    location.reload();
                });
        }
    }

    // Fungsi untuk mengecek shutdown_time dan otomatis memanggil finishBilling jika waktu sudah habis
    function checkShutdownTime() {
        document.querySelectorAll('.billing-card-pending').forEach(card => {
            const shutdownTimeStr = card.getAttribute('data-shutdown-time');
            const deviceId = card.getAttribute('data-device-id');
            if (shutdownTimeStr) {
                const shutdownTime = new Date(shutdownTimeStr);
                const now = new Date();
                // Jika waktu sekarang sudah melebihi shutdown_time
                if (now >= shutdownTime) {
                    // Hapus event konfirmasi agar tidak terjadi duplikasi pemanggilan
                    const finishBtn = document.getElementById('finish-btn-' + deviceId);
                    if (finishBtn) {
                        finishBtn.disabled = true;
                    }
                    // Panggil finishBilling secara otomatis tanpa konfirmasi
                    autoFinishBilling(deviceId);
                }
            }
        });
    }

    // Panggil pengecekan saat halaman dimuat dan secara berkala (misalnya setiap 10 detik)
    document.addEventListener('DOMContentLoaded', () => {
        checkShutdownTime();
        setInterval(checkShutdownTime, 10000); // cek setiap 10 detik
    });
</script>
