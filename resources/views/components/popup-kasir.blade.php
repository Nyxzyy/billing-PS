{{-- Modal Mulai Shift --}}
<div id="modalMulaiShift" class="invisible fixed inset-0 bg-black/50 flex items-center justify-center z-50 px-4">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-sm md:max-w-md">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-semibold">Mulai Shift Kerja</h2>
            <button type="button" onclick="closeShiftModal()" class="text-gray-400 hover:text-gray-600">
                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        
        <p class="text-sm text-gray-600 mb-6">Selamat datang, {{ Auth::user()->name }}! Silakan mulai shift untuk memulai transaksi hari ini.</p>

        <div class="flex flex-col gap-3">
            <button onclick="startShift()" class="w-full bg-[#3E81AB] hover:bg-[#2C5F7C] text-white px-4 py-2 rounded text-sm">
                Mulai Shift
            </button>
            <button onclick="closeShiftModal()" class="w-full bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded text-sm">
                Nanti Saja
            </button>
        </div>
    </div>
</div>

{{-- Modal Kendala --}}
<div id="modalKendala" class="invisible fixed inset-0 bg-black/50 flex items-center justify-center z-50 px-4">
    <div class="bg-white p-5 rounded-lg w-full max-w-sm md:max-w-md">
        <h2 class="text-sm font-bold text-center mb-4">Kendala Device</h2>
        <input type="hidden" id="selectedDeviceId">
        <input type="hidden" id="selectedDeviceName">
        <label class="text-xs text-[#656565]">Ketikkan Kendalanya</label>
        <textarea id="textareaKendala" class="w-full border border-[#C0C0C0] p-2 rounded mt-1"
            placeholder="Ketikkan Kendalanya..."></textarea>

        <div class="flex items-center mt-2">
            <input type="checkbox" id="konfirmasi" class="mr-2" onchange="toggleKunciButton()">
            <label for="konfirmasi" class="text-[#4E4E4E] text-xs">Konfirmasi Kunci Device</label>
        </div>

        <div class="flex justify-end mt-4">
            <button class="bg-[#C6C6C6] text-[#4E4E4E] px-4 py-2 rounded mr-2 text-xs"
                onclick="closeModalKendala()">Batal</button>
            <button id="btnKunci" class="bg-[#3E81AB] text-white px-4 py-2 rounded text-xs cursor-not-allowed" disabled
                onclick="openModalKunci()">Kunci</button>
        </div>
    </div>
</div>

<div id="modalKonfirmasiKunci" class="invisible fixed inset-0 bg-black/50 flex items-center justify-center z-50 px-4">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-sm md:max-w-md">
        <h2 class="text-sm font-bold">Konfirmasi Kunci Device</h2>
        <p class="mt-2 text-sm">Apakah Anda yakin ingin mengunci Device <span id="deviceNameConfirm"
                class="text-[#FF4747] font-semibold"></span> ini?</p>

        <div class="flex justify-center w-full mt-4 space-x-2">
            <button class="w-full bg-[#C6C6C6] text-[#4E4E4E] px-4 py-2 rounded text-xs"
                onclick="closeModal('modalKonfirmasiKunci')">Tidak, Kembali</button>
            <button onclick="submitKendala()" class="w-full bg-[#FF4747] text-white px-4 py-2 rounded text-xs">Kunci dan Laporkan</button>
        </div>
    </div>
</div>

{{-- Modal Detail Kendala --}}
<div id="modalDetailKendala" class="invisible fixed inset-0 bg-black/50 flex items-center justify-center z-50 px-4">
    <div class="bg-white p-5 rounded-lg w-full max-w-sm md:max-w-md">
        <h2 class="text-sm font-bold text-center mb-4">Detail Kendala Device</h2>
        <input type="hidden" id="detailDeviceId">
        <input type="hidden" id="detailDeviceName">
        <label class="text-xs text-[#656565]">Kendala</label>
        <textarea id="textareaDetailKendala" class="w-full border border-[#C0C0C0] p-2 rounded mt-1" readonly></textarea>

        <div class="flex justify-end mt-4">
            <button class="bg-[#C6C6C6] text-[#4E4E4E] px-4 py-2 rounded mr-2 text-xs"
                onclick="closeModal('modalDetailKendala')">Tutup</button>
            <button class="bg-[#3E81AB] text-white px-4 py-2 rounded text-xs"
                onclick="openModalBukaKunci()">Buka Kunci</button>
        </div>
    </div>
</div>

<div id="modalBukaKunci" class="invisible fixed inset-0 bg-black/50 flex items-center justify-center z-50 px-4">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-sm md:max-w-md">
        <h2 class="text-sm font-bold">Konfirmasi Buka Kunci Device</h2>
        <p class="mt-2 text-sm">Apakah Anda yakin ingin membuka kunci Device <span id="deviceNameBukaKunci"
                class="text-[#FF4747] font-semibold"></span> ini?</p>

        <div class="flex justify-center w-full mt-4 space-x-2">
            <button class="w-full bg-[#C6C6C6] text-[#4E4E4E] px-4 py-2 rounded text-xs"
                onclick="closeModal('modalBukaKunci')">Tidak, Kembali</button>
            <button onclick="resolveKendala()" class="w-full bg-[#FF4747] text-white px-4 py-2 rounded text-xs">Buka Kunci</button>
        </div>
    </div>
</div>

<div id="modalDetailPaket" class="invisible fixed inset-0 bg-black/50 flex items-center justify-center z-50 px-4">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-sm md:max-w-md relative">
        <button onclick="closeModal('modalDetailPaket')" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
            </svg>
        </button>
        <h2 class="text-sm font-bold">Detail Billing</h2>

        <div class="border border-black rounded-md p-3 mt-2 text-sm">
            <p id="">Device:</p>
            <p id="">Paket:</p>
            <p id="">Jam Selesai:</p>
            <p id="">Sisa Waktu:</p>
        </div>

        <p class="mt-3 text-sm">Apakah Anda yakin ingin memulai billing dengan Paket Ini?</p>

        <div class="justify-center w-full mt-4 space-x-2">
        <button class="w-full bg-[#3E81AB] text-white px-4 py-2 rounded mr-2 text-xs mb-2" id="btnTambahBilling"
                onclick="closeModal('modalDetailPaket'); openModalPilihPaket(true)">Tambah Billing</button>
            <button id="btnStop" class="w-full bg-[#FB2C36] text-white px-4 py-2 rounded text-xs"
                onclick="stopDevice()">STOP</button>
        </div>
    </div>
</div>

{{-- Logout Confirmation Modal --}}
<div id="modalLogoutConfirm" class="invisible fixed inset-0 bg-black/50 flex items-center justify-center z-50 px-4">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-sm md:max-w-md">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-semibold text-red-600">Peringatan!</h2>
            <button type="button" onclick="closeLogoutModal()" class="text-gray-400 hover:text-gray-600">
                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        
        <p class="text-sm text-gray-600 mb-6">Shift anda masih aktif. Anda harus menutup buku terlebih dahulu sebelum keluar.</p>

        <div class="flex flex-col gap-3">
            <button onclick="endShiftAndLogout()" class="w-full bg-[#3E81AB] hover:bg-[#2C5F7C] text-white px-4 py-2 rounded text-sm">
                Tutup Buku & Keluar
            </button>
            <button onclick="forceLogout()" class="w-full bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded text-sm">
                Lanjutkan Keluar
            </button>
            <button onclick="closeLogoutModal()" class="w-full bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded text-sm">
                Batal
            </button>
        </div>
    </div>
</div>

{{-- Modal Pilih Paket --}}
<div id="modalPilihPaket"
    class="invisible fixed inset-0 bg-white/10 backdrop-blur-xs flex items-center justify-center z-50 px-4">
    <div class="bg-white p-5 rounded-lg w-full max-w-sm md:max-w-md shadow-lg">
        <h2 class="text-sm font-bold text-center mb-4">Pilih Paket Billing</h2>

        <label class="text-xs text-[#656565]">Pilih Paket</label>
        <select id="pilihPaket" class="w-full border border-[#C0C0C0] p-2 rounded mt-1 text-[#969696]">
            <option value="" disabled selected>Pilih Paket</option>
            @if (isset($packages) && count($packages) > 0)
                @foreach ($packages as $package)
                    <option value="{{ $package->id }}">{{ $package->package_name }} - Rp.
                        {{ number_format($package->total_price, 0, ',', '.') }}</option>
                @endforeach
            @else
                <option value="">Tidak Ada Paket Yang Terdeteksi</option>
            @endif
        </select>

        <div class="flex items-center mt-2">
            <input type="checkbox" id="openPaket" class="mr-2">
            <label for="openPaket" class="text-[#4E4E4E] text-xs">Open (Tanpa Batas Waktu)</label>
        </div>

        <div class="flex justify-end mt-4">
            <button class="bg-[#C6C6C6] text-[#4E4E4E] px-4 py-2 rounded mr-2 text-xs"
                onclick="closeModal('modalPilihPaket')">Batal</button>
            <button class="bg-[#3E81AB] text-white px-4 py-2 rounded text-xs"
                onclick="openModalKonfirmasi()">Lanjut</button>
        </div>
    </div>
</div>

{{-- Modal Konfirmasi Paket --}}
<div id="modalKonfirmasi"
    class="invisible fixed inset-0 bg-white/10 backdrop-blur-xs flex items-center justify-center z-50 px-4">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-sm md:max-w-md">
        <h2 class="text-sm font-bold">Konfirmasi Paket Billing</h2>

        <div class="border border-black rounded-md p-3 mt-2 text-sm">
            <p id="paketDetail"></p>
            <p id="hargaDetail"></p>
        </div>

        <p class="mt-3 text-sm">Apakah Anda yakin ingin memulai billing dengan Paket Ini?</p>

        <div class="flex justify-center w-full mt-4 space-x-2">
            <button class="w-full bg-[#C6C6C6] text-[#4E4E4E] px-4 py-2 rounded text-xs"
                onclick="closeModal('modalKonfirmasi')">Batal</button>
            <button id="btnKonfirmasi" class="w-full bg-[#64DF64] text-white px-4 py-2 rounded text-xs">Mulai</button>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Store intervals for each device
    let timerIntervals = {};

    function openModal(modalToShow, modalToHide = null) {
        if (modalToHide) {
            document.getElementById(modalToHide).classList.add("invisible");
        }
        const modal = document.getElementById(modalToShow);
        modal.classList.remove("invisible");
    }

    function closeModal(modalToHide) {
        const modal = document.getElementById(modalToHide);
        modal.classList.add("invisible");

        // If closing the detail paket modal, clear all timer intervals
        if (modalToHide === 'modalDetailPaket') {
            // Get the current device ID from the modal
            const deviceId = modal.getAttribute('data-current-device');
            
            // Clear all timer intervals
            Object.keys(timerIntervals).forEach(key => {
                clearInterval(timerIntervals[key]);
                delete timerIntervals[key];
            });
            
            // Reset timer elements
            const sisaWaktuLine = modal.querySelector('p:nth-child(4)');
            if (sisaWaktuLine) {
                sisaWaktuLine.removeAttribute('data-start-time');
                sisaWaktuLine.removeAttribute('data-shutdown');
                sisaWaktuLine.removeAttribute('data-device-id');
                sisaWaktuLine.className = '';
            }
        }

        if (modalToHide === "modalPilihPaket") {
            resetPilihPaket();
        }
    }

    let isTambahBilling = false;

    function openModalPilihPaket(isTambah, deviceId = null) {
        isTambahBilling = isTambah;
        
        // If deviceId is not provided directly, try to get it from the modal
        if (!deviceId) {
            const modalDetailPaket = document.getElementById('modalDetailPaket');
            deviceId = modalDetailPaket.getAttribute('data-current-device');
        }

        if (!deviceId) {
            alert("Device ID tidak ditemukan!");
            return;
        }

        // Set device ID ke button konfirmasi
        let btnKonfirmasi = document.getElementById("btnKonfirmasi");
        btnKonfirmasi.setAttribute("data-device-id", deviceId);
        btnKonfirmasi.setAttribute("data-is-adding", isTambah);

        let openCheckbox = document.getElementById("openPaket");
        let openLabel = document.querySelector("label[for='openPaket']");

        if (isTambahBilling) {
            openCheckbox.disabled = true;
            openLabel.style.color = "#A0A0A0";
            document.getElementById("pilihPaket").disabled = false;
        } else {
            openCheckbox.disabled = false;
            openLabel.style.color = "#4E4E4E";
        }

        openModal("modalPilihPaket");
    }

    function openModalKonfirmasi() {
        let paketDropdown = document.getElementById("pilihPaket");
        let openCheckbox = document.getElementById("openPaket");
        let paketDetail = document.getElementById("paketDetail");
        let hargaDetail = document.getElementById("hargaDetail");
        let btnKonfirmasi = document.getElementById("btnKonfirmasi");
        let teksKonfirmasi = document.querySelector("#modalKonfirmasi p.mt-3");

        // Get device ID from the button that was clicked
        let deviceId = btnKonfirmasi.getAttribute("data-device-id");

        if (!deviceId) {
            alert("Device ID tidak ditemukan!");
            return;
        }

        // Store selected package ID in the button's data attribute
        btnKonfirmasi.setAttribute("data-package-id", paketDropdown.value);
        btnKonfirmasi.setAttribute("data-is-open", openCheckbox.checked);

        if (openCheckbox.checked) {
            paketDetail.innerHTML = "Paket: <span class='font-semibold'>Open (Tanpa Batas Waktu)</span>";
            hargaDetail.innerHTML = "Harga: <span class='font-semibold'>Dihitung di akhir</span>";
            teksKonfirmasi.innerHTML =
                "Apakah Anda yakin ingin memulai billing dengan paket <strong>Open (Tanpa Batas Waktu)?</strong>";
            btnKonfirmasi.innerHTML = "Mulai";
        } else {
            let selectedOption = paketDropdown.options[paketDropdown.selectedIndex];

            if (!selectedOption || selectedOption.value === "") {
                alert("Pilih paket terlebih dahulu!");
                return;
            }

            let paketText = selectedOption.text.split(" - Rp.");
            let paketName = paketText[0].trim();
            let paketPrice = paketText[1] ? `Rp. ${paketText[1].trim()}` : "Rp. 0";

            paketDetail.innerHTML = `Paket: <span class='font-semibold'>${paketName}</span>`;
            hargaDetail.innerHTML = `Harga: <span class='font-semibold'>${paketPrice}</span>`;
            teksKonfirmasi.innerHTML =
                `Apakah Anda yakin ingin memulai billing dengan paket <strong>${paketName}?</strong>`;

            btnKonfirmasi.innerHTML = isTambahBilling ? "Print Struk dan Tambah" : "Print Struk dan Mulai";
        }

        closeModal("modalPilihPaket");
        openModal("modalKonfirmasi");
    }

    document.addEventListener("DOMContentLoaded", function() {
        let paketDropdown = document.getElementById("pilihPaket");
        let openCheckbox = document.getElementById("openPaket");
        let openLabel = document.querySelector("label[for='openPaket']");

        paketDropdown.addEventListener("change", function() {
            if (paketDropdown.value) {
                openCheckbox.disabled = true;
                openLabel.style.color = "#D8D8D8";
            } else {
                openCheckbox.disabled = false;
                openLabel.style.color = "#4E4E4E";
            }
        });

        openCheckbox.addEventListener("change", function() {
            let options = paketDropdown.querySelectorAll("option");

            if (openCheckbox.checked) {
                paketDropdown.disabled = true;
                options.forEach(opt => opt.style.color = "#969696");
            } else {
                paketDropdown.disabled = false;
                options.forEach(opt => opt.style.color = "black");
            }
        });
    });

    document.addEventListener("DOMContentLoaded", function() {
        let textareaKendala = document.getElementById("textareaKendala");
        let konfirmasiCheckbox = document.getElementById("konfirmasi");
        let btnKunci = document.getElementById("btnKunci");

        function checkForm() {
            let isFilled = textareaKendala.value.trim() !== "" && konfirmasiCheckbox.checked;
            btnKunci.disabled = !isFilled;
            btnKunci.classList.toggle("cursor-not-allowed", !isFilled);
            btnKunci.classList.toggle("cursor-pointer", isFilled);
        }

        textareaKendala.addEventListener("input", checkForm);
        konfirmasiCheckbox.addEventListener("change", checkForm);
    });

    function closeModalKendala() {
        resetModalKendala();
        document.getElementById("modalKendala").classList.add("invisible");
    }

    function openModalKunci() {
        resetModalKendala();
        openModal('modalKonfirmasiKunci', 'modalKendala');
    }

    function resetModalKendala() {
        let textareaKendala = document.getElementById("textareaKendala");
        let konfirmasiCheckbox = document.getElementById("konfirmasi");
        let btnKunci = document.getElementById("btnKunci");

        textareaKendala.value = "";
        konfirmasiCheckbox.checked = false;
        btnKunci.disabled = true;
        btnKunci.classList.add("cursor-not-allowed");
        btnKunci.classList.remove("cursor-pointer");
    }

    function resetPilihPaket() {
        let paketDropdown = document.getElementById("pilihPaket");
        let openCheckbox = document.getElementById("openPaket");
        let openLabel = document.querySelector("label[for='openPaket']");

        // Reset dropdown ke default
        paketDropdown.selectedIndex = 0;
        paketDropdown.disabled = false;

        // Reset checkbox ke default
        openCheckbox.checked = false;
        openCheckbox.disabled = false;
        openLabel.style.color = "#4E4E4E";

        // Reset warna option dropdown
        let options = paketDropdown.querySelectorAll("option");
        options.forEach(opt => opt.style.color = "black");

        btnKonfirmasi.innerHTML = isTambahBilling ? "Print Struk dan Tambah" : "Print Struk dan Mulai";
    }

    // Start Billing 
    document.addEventListener("DOMContentLoaded", function() {
        let btnKonfirmasi = document.getElementById("btnKonfirmasi");

        btnKonfirmasi.addEventListener("click", function() {
            let deviceId = this.getAttribute("data-device-id");
            let packageId = this.getAttribute("data-package-id");
            let isOpen = this.getAttribute("data-is-open") === "true";
            let isAdding = this.getAttribute("data-is-adding") === "true";

            if (!deviceId) {
                alert("Device ID tidak ditemukan!");
                return;
            }

            if (!isOpen && !packageId) {
                alert("Pilih paket terlebih dahulu!");
                return;
            }

            const endpoint = isAdding ? "{{ route('billing.add') }}" : "{{ route('billing.start') }}";

            console.log('Sending request:', {
                device_id: deviceId,
                package_id: packageId,
                is_open: isOpen,
                is_adding: isAdding
            });

            fetch(endpoint, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        device_id: deviceId,
                        package_id: packageId,
                        is_open: isOpen,
                        is_adding: isAdding
                    }),
                })
                .then(response => {
                    if (!response.ok) {
                        return response.json().then(err => {
                            throw new Error(err.message || 'Network response was not ok');
                        });
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.status === 'Berjalan') {
                        let message = isAdding ? "Billing berhasil ditambahkan!" :
                            "Billing telah dimulai!";
                        if (data.shutdown_time) {
                            const shutdownTime = new Date(data.shutdown_time);
                            const formattedTime = shutdownTime.toLocaleTimeString('id-ID', {
                                hour: '2-digit',
                                minute: '2-digit',
                                hour12: false
                            });
                            message += `\nWaktu selesai: ${formattedTime}`;
                        }
                        alert(message);
                        closeModal('modalKonfirmasi');
                        location.reload();
                    } else {
                        alert(data.message || "Gagal memulai billing!");
                    }
                })
                .catch(error => {
                    console.error("Error:", error);
                    alert(error.message ||
                        "Terjadi kesalahan saat memulai billing. Silakan coba lagi.");
                });
        });
    });

    function openModalDetailPaket(deviceId, deviceName, shutdownTime, packageName, fullShutdownTime, lastUsedAt) {
        // Clear any existing intervals
        Object.keys(timerIntervals).forEach(key => {
            clearInterval(timerIntervals[key]);
            delete timerIntervals[key];
        });

        const modalDetail = document.getElementById('modalDetailPaket');
        modalDetail.setAttribute('data-current-device', deviceId);

        modalDetail.querySelector('p:nth-child(1)').innerHTML =
            `Device: <span class="font-semibold">${deviceName}</span>`;
        modalDetail.querySelector('p:nth-child(2)').innerHTML =
            `Paket: <span class="font-semibold">${packageName || 'Tidak ada paket'}</span>`;
        modalDetail.querySelector('p:nth-child(3)').innerHTML =
            `Jam Selesai: <span class="font-semibold">${shutdownTime}</span>`;

        const sisaWaktuLine = modalDetail.querySelector('p:nth-child(4)');
        
        // Reset timer attributes
        sisaWaktuLine.removeAttribute('data-start-time');
        sisaWaktuLine.removeAttribute('data-shutdown');
        sisaWaktuLine.removeAttribute('data-device-id');
        sisaWaktuLine.className = '';
        
        const btnTambahBilling = document.getElementById('btnTambahBilling');
        
        if (packageName === 'Open Billing' && lastUsedAt) {
            sisaWaktuLine.className = 'running-timer';
            sisaWaktuLine.setAttribute('data-start-time', lastUsedAt);
            sisaWaktuLine.setAttribute('data-device-id', deviceId);
            
            // Initial update
            updateRunningTime(sisaWaktuLine);
            
            // Start interval
            timerIntervals[deviceId] = setInterval(() => {
                updateRunningTime(sisaWaktuLine);
            }, 1000);
            
            btnTambahBilling.disabled = true;
            btnTambahBilling.classList.add('opacity-50', 'cursor-not-allowed');
        } else if (fullShutdownTime && fullShutdownTime !== 'null') {
            sisaWaktuLine.setAttribute('data-shutdown', fullShutdownTime);
            sisaWaktuLine.setAttribute('data-device-id', deviceId);
            sisaWaktuLine.className = 'countdown-timer';
            
            updateCountdown(sisaWaktuLine, deviceId);
            timerIntervals[deviceId] = setInterval(() => {
                updateCountdown(sisaWaktuLine, deviceId);
            }, 1000);
            
            btnTambahBilling.disabled = false;
            btnTambahBilling.classList.remove('opacity-50', 'cursor-not-allowed');
        } else {
            sisaWaktuLine.innerHTML = 'Sisa Waktu: <span class="font-semibold">-</span>';
            btnTambahBilling.disabled = false;
            btnTambahBilling.classList.remove('opacity-50', 'cursor-not-allowed');
        }

        document.getElementById('btnStop').setAttribute('data-device-id', deviceId);
        openModal('modalDetailPaket');
    }

    // Function to update running time for Open Billing
    function updateRunningTime(timer) {
        const startTimeStr = timer.getAttribute('data-start-time');
        if (!startTimeStr) {
            console.error('No start time found');
            return;
        }

        const startTime = new Date(startTimeStr);
        const now = getCurrentTime();
        
        // Ensure we're using valid dates
        if (isNaN(startTime.getTime())) {
            console.error('Invalid start time:', startTimeStr);
            return;
        }

        const elapsedTime = now - startTime;
        
        // Calculate hours, minutes and seconds
        const hours = Math.floor(elapsedTime / (1000 * 60 * 60));
        const minutes = Math.floor((elapsedTime % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((elapsedTime % (1000 * 60)) / 1000);

        // Format the time
        let timeString = '';
        if (hours > 0) {
            timeString += `${hours} jam `;
        }
        if (minutes > 0 || hours > 0) {
            timeString += `${minutes} menit `;
        }
        timeString += `${seconds} detik`;

        timer.innerHTML = `Durasi: <span class="font-semibold">${timeString}</span>`;
    }

    // Countdown timer function
    function updateCountdown(timer, deviceId) {
        // Check if timer is still valid and has the correct device ID
        if (!timer.isConnected || timer.getAttribute('data-device-id') !== deviceId) {
            if (timerIntervals[deviceId]) {
                clearInterval(timerIntervals[deviceId]);
                delete timerIntervals[deviceId];
            }
            return;
        }

        const shutdownTimeStr = timer.dataset.shutdown;
        if (!shutdownTimeStr) {
            console.error('No shutdown time found for device:', deviceId);
            return;
        }

        const shutdownTime = new Date(shutdownTimeStr);
        const now = getCurrentTime();
        
        // Log time comparison for debugging
        console.debug('Time comparison:', {
            deviceId,
            shutdownTime: shutdownTime.toISOString(),
            currentTime: now.toISOString(),
            remainingTime: shutdownTime.getTime() - now.getTime()
        });

        // Calculate remaining time
        const remainingTime = shutdownTime.getTime() - now.getTime();

        // If time is up
        if (remainingTime <= 0) {
            console.log(`Device ${deviceId} billing finished at ${now.toISOString()}`);
            timer.innerHTML = 'Sisa Waktu: <span class="font-semibold">Waktu Habis</span>';
            updateDeviceStatus(deviceId, 'Pending');
            if (timerIntervals[deviceId]) {
                clearInterval(timerIntervals[deviceId]);
                delete timerIntervals[deviceId];
            }
            return;
        }

        // Calculate hours, minutes and seconds
        const hours = Math.floor(remainingTime / (1000 * 60 * 60));
        const minutes = Math.floor((remainingTime % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((remainingTime % (1000 * 60)) / 1000);

        // Format the time
        let timeString = '';
        if (hours > 0) {
            timeString += `${hours} jam `;
        }
        if (minutes > 0 || hours > 0) {
            timeString += `${minutes} menit `;
        }
        timeString += `${seconds} detik`;

        timer.innerHTML = `Sisa Waktu: <span class="font-semibold">${timeString}</span>`;
    }

    // Function to check all running devices
    function checkAllRunningDevices() {
        document.querySelectorAll('.billing-card-running').forEach(function(card) {
            const shutdownTimeStr = card.getAttribute('data-shutdown-time');
            const deviceId = card.getAttribute('data-device-id');
            
            if (!shutdownTimeStr || shutdownTimeStr === 'null' || !deviceId) return;

            const shutdownTime = new Date(shutdownTimeStr);
            const now = getCurrentTime();
            
            // Log time comparison for debugging
            console.debug('Device status check:', {
                deviceId,
                shutdownTime: shutdownTime.toISOString(),
                currentTime: now.toISOString(),
                remainingTime: shutdownTime.getTime() - now.getTime()
            });

            if (shutdownTime.getTime() <= now.getTime()) {
                console.log(`Device ${deviceId} time expired at ${shutdownTime.toISOString()}, current time: ${now.toISOString()}`);
                updateDeviceStatus(deviceId, 'Pending');
            }
        });
    }

    // Server time synchronization
    let serverTimeOffset = 0;
    let lastSyncTime = 0;

    async function syncTime() {
        try {
            const startTime = Date.now();
            const response = await fetch('/kasir/server-time');
            const data = await response.json();
            const endTime = Date.now();
            
            // Calculate network latency (round trip time / 2)
            const networkLatency = Math.floor((endTime - startTime) / 2);
            
            // Parse server time and adjust for network latency
            const serverTime = new Date(data.timestamp);
            serverTime.setMilliseconds(serverTime.getMilliseconds() + networkLatency);
            
            // Calculate new offset
            const clientTime = new Date();
            serverTimeOffset = serverTime.getTime() - clientTime.getTime();
            
            console.debug('Time sync completed:', {
                serverTime: serverTime.toISOString(),
                clientTime: clientTime.toISOString(),
                offset: serverTimeOffset,
                networkLatency,
                timezone: data.timezone
            });
            
            lastSyncTime = Date.now();
        } catch (error) {
            console.error('Failed to sync time with server:', error);
        }
    }

    // Get current time adjusted by server offset
    function getCurrentTime() {
        return new Date(Date.now() + serverTimeOffset);
    }

    // Initialize when page loads
    document.addEventListener('DOMContentLoaded', async function() {
        // Initial time sync
        await syncTime();
        
        // Start real-time checking
        setInterval(checkAllRunningDevices, 5000);
        
        // Sync time every minute
        setInterval(syncTime, 60000);
        
        // Initial device check
        checkAllRunningDevices();
        
        // Check shift status
        checkShiftStatus();
    });

    function updateDeviceStatus(deviceId, status) {
        if (!deviceId) {
            console.error('Device ID is missing!');
            return;
        }

        console.log(`Updating device ${deviceId} status to ${status}`);
        
        fetch('/kasir/billing/update-status', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                device_id: deviceId,
                status: status,
                server_time: getCurrentTime().toISOString()
            })
        })
        .then(response => response.json())
        .then(data => {
            console.log('Response:', data);
            
            if (data.status === 'success') {
                console.log(`Successfully updated device ${deviceId} status to ${status}`);
                location.reload();
            } else {
                console.error('Error updating device status:', data.message);
                alert(data.message || 'Terjadi kesalahan saat mengubah status device');
            }
        })
        .catch(error => {
            console.error('Error updating device status:', error);
            alert('Terjadi kesalahan saat mengubah status device');
        });
    }

    function stopDevice() {
        const deviceId = document.getElementById('btnStop').getAttribute('data-device-id');
        if (!deviceId) {
            console.error('Device ID is missing!');
            alert('Error: Device ID tidak ditemukan!');
            return;
        }

        console.log(`Stopping device ${deviceId}`);
        updateDeviceStatus(deviceId, 'Pending');
    }

    document.addEventListener('DOMContentLoaded', function() {
        checkShiftStatus();
    });

    function checkShiftStatus() {
        fetch('/kasir/shift/check-status')
            .then(response => response.json())
            .then(data => {
                if (!data.hasActiveShift) {
                    openModal('modalMulaiShift');
                } else {
                    closeModal('modalMulaiShift');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('error', 'Terjadi kesalahan saat memeriksa status shift');
            });
    }

    function startShift() {
        fetch('/kasir/shift/start', {
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
                showNotification('success', 'Shift berhasil dimulai');
                window.location.reload();
            } else {
                showNotification('error', data.message || 'Terjadi kesalahan saat memulai shift');
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

    function checkShiftBeforeLogout() {
        fetch('/kasir/shift/check-status')
            .then(response => response.json())
            .then(data => {
                if (data.hasActiveShift) {
                    openModal('modalLogoutConfirm');
                } else {
                    forceLogout();
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('error', 'Terjadi kesalahan saat memeriksa status shift');
            });
    }

    function endShiftAndLogout() {
        fetch('/kasir/shift/end', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                showNotification('success', 'Shift berhasil diakhiri');
                forceLogout();
            } else {
                showNotification('error', data.message || 'Terjadi kesalahan saat mengakhiri shift');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('error', 'Terjadi kesalahan saat mengakhiri shift');
        });
    }

    function forceLogout() {
        document.getElementById('logout-form').submit();
    }

    function closeLogoutModal() {
        closeModal('modalLogoutConfirm');
    }
</script>

<script>
    function openModalKendala(deviceId, deviceName) {
        document.getElementById('selectedDeviceId').value = deviceId;
        document.getElementById('selectedDeviceName').value = deviceName;
        openModal('modalKendala');
    }

    function closeModalKendala() {
        document.getElementById('textareaKendala').value = '';
        document.getElementById('konfirmasi').checked = false;
        document.getElementById('btnKunci').disabled = true;
        closeModal('modalKendala');
    }

    function toggleKunciButton() {
        const checkbox = document.getElementById('konfirmasi');
        const btnKunci = document.getElementById('btnKunci');
        btnKunci.disabled = !checkbox.checked;
        btnKunci.classList.toggle("cursor-not-allowed", !checkbox.checked);
        btnKunci.classList.toggle("cursor-pointer", checkbox.checked);
    }

    function openModalKunci() {
        const deviceName = document.getElementById('selectedDeviceName').value;
        document.getElementById('deviceNameConfirm').textContent = deviceName;
        closeModal('modalKendala');
        openModal('modalKonfirmasiKunci');
    }

    function submitKendala() {
        const deviceId = document.getElementById('selectedDeviceId').value;
        const issue = document.getElementById('textareaKendala').value;
        
        if (!issue.trim()) {
            showNotification('error', 'Harap isi kendala terlebih dahulu');
            return;
        }

        fetch('/kasir/kendala/report', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                device_id: deviceId,
                issue: issue
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                showNotification('success', 'Kendala berhasil dilaporkan');
                closeModal('modalKonfirmasiKunci');
                window.location.reload(); // Reload to update device status
            } else {
                showNotification('error', data.message || 'Terjadi kesalahan saat melaporkan kendala');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('error', 'Terjadi kesalahan saat melaporkan kendala');
        });
    }

    function showKendalaDetail(deviceId, deviceName) {
        document.getElementById('detailDeviceId').value = deviceId;
        document.getElementById('detailDeviceName').value = deviceName;
        
        // Fetch kendala details
        fetch(`/kasir/kendala/${deviceId}/latest`)
            .then(response => response.json())
            .then(data => {
                if (data.kendala) {
                    document.getElementById('textareaDetailKendala').value = data.kendala.issue;
                    openModal('modalDetailKendala');
                } else {
                    showNotification('error', 'Tidak dapat menemukan detail kendala');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('error', 'Terjadi kesalahan saat mengambil detail kendala');
            });
    }

    function openModalBukaKunci() {
        const deviceName = document.getElementById('detailDeviceName').value;
        document.getElementById('deviceNameBukaKunci').textContent = deviceName;
        closeModal('modalDetailKendala');
        openModal('modalBukaKunci');
    }

    function resolveKendala() {
        const deviceId = document.getElementById('detailDeviceId').value;
        
        fetch('/kasir/kendala/resolve', {
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
                showNotification('success', 'Device berhasil dibuka');
                closeModal('modalBukaKunci');
                window.location.reload(); // Reload to update device status
            } else {
                showNotification('error', data.message || 'Terjadi kesalahan saat membuka device');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('error', 'Terjadi kesalahan saat membuka device');
        });
    }
</script>
@endpush
