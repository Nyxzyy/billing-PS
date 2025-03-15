{{-- Modal Mulai Shift --}}
<div id="modalMulaiShift"
    class="invisible fixed inset-0 bg-white/10 backdrop-blur-xs flex items-center justify-center z-50">
    <div class="bg-white p-6 rounded-lg shadow-lg w-1/4">
        <h2 class="text-sm font-bold">Mulai Shift Kerja</h2>
        <p class="mt-2 text-sm text-[#545454]">Klik Tombol dibawah ini untuk memulai shift anda saat ini.</p>

        <div class="flex justify-center w-full mt-4 space-x-2">
            <button class="w-full bg-[#64DF64] text-white px-4 py-2 rounded text-xs">Mulai Shift</button>
        </div>
        <div class="border-t border-dashed border-[#DFDFDF] w-full mt-4 pt-2"></div>
    </div>
</div>

{{-- Modal Kendala --}}
<div id="modalKendala" class="invisible fixed inset-0 bg-white/10 backdrop-blur-xs flex items-center justify-center z-50">
    <div class="bg-white p-5 rounded-lg w-96">
        <h2 class="text-sm font-bold text-center mb-4">Kendala Device</h2>
        <label class="text-xs text-[#656565]">Ketikkan Kendalanya</label>
        <textarea id="textareaKendala" class="w-full border border-[#C0C0C0] p-2 rounded mt-1"
            placeholder="Ketikkan Kendalanya..."></textarea>

        <div class="flex items-center mt-2">
            <input type="checkbox" id="konfirmasi" class="mr-2">
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

<div id="modalKonfirmasiKunci"
    class="invisible fixed inset-0 bg-white/10 backdrop-blur-xs flex items-center justify-center z-50">
    <div class="bg-white p-6 rounded-lg shadow-lg w-1/4">
        <h2 class="text-sm font-bold">Konfirmasi Kunci Device</h2>
        <p class="mt-2 text-sm">Apakah Anda yakin ingin mengunci Device <span class="text-[#FF4747] font-semibold">"PS
                2"</span> ini?</p>

        <div class="flex justify-center w-full mt-4 space-x-2">
            <button class="w-full bg-[#C6C6C6] text-[#4E4E4E] px-4 py-2 rounded mr-2 text-xs"
                onclick="closeModal('modalKonfirmasiKunci')">Tidak, Kembali</button>
            <button class="w-full bg-[#FF4747] text-white px-4 py-2 rounded text-xs">Kunci dan Laporkan</button>
        </div>
    </div>
</div>

{{-- Modal Detail Kendala --}}
<div id="modalDetailKendala"
    class="invisible fixed inset-0 bg-white/10 backdrop-blur-xs flex items-center justify-center z-50">
    <div class="bg-white p-5 rounded-lg w-96">
        <h2 class="text-sm font-bold text-center mb-4">Detail Kendala Device</h2>
        <label class="text-xs text-[#656565]">Ketikkan Kendalanya</label>
        <textarea class="w-full border border-[#C0C0C0] p-2 rounded mt-1" placeholder="Ketikkan Kendalanya. . . ."></textarea>
        <div class="flex items-center">
            <input type="checkbox" id="konfirmasi" class="mr-2">
            <label for="konfirmasi" class="text-[#4E4E4E] text-xs">Konfirmasi Kunci Device</label>
        </div>

        <div class="flex justify-end mt-4">
            <button class="bg-[#C6C6C6] text-[#4E4E4E] px-4 py-2 rounded mr-2 text-xs"
                onclick="closeModal('modalDetailKendala')">Batal</button>
            <button class="bg-[#3E81AB] text-white px-4 py-2 rounded text-xs"
                onclick="openModal('modalBukaKunci', 'modalDetailKendala')">Buka</button>
        </div>
    </div>
</div>

<div id="modalBukaKunci"
    class="invisible fixed inset-0 bg-white/10 backdrop-blur-xs flex items-center justify-center z-50">
    <div class="bg-white p-6 rounded-lg shadow-lg w-1/4">
        <h2 class="text-sm font-bold ">Konfirmasi Buka Kunci Device</h2>
        <p class="mt-2 text-sm">Apakah Anda yakin ingin membuka kunci Device <span
                class="text-[#FF4747] font-semibold">"PS 2"</span> ini?</p>

        <div class="flex justify-center w-full mt-4 space-x-2">
            <button class="w-full bg-[#C6C6C6] text-[#4E4E4E] px-4 py-2 rounded mr-2 text-xs"
                onclick="closeModal('modalBukaKunci')">Tidak, Kembali</button>
            <button class="w-full bg-[#FF4747] text-white px-4 py-2 rounded text-xs">Buka Kunci</button>
        </div>
    </div>
</div>

{{-- Modal Pilih Paket --}}
<div id="modalPilihPaket"
    class="invisible fixed inset-0 bg-white/10 backdrop-blur-xs flex items-center justify-center z-50">
    <div class="bg-white p-5 rounded-lg w-96 shadow-lg">
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
    class="invisible fixed inset-0 bg-white/10 backdrop-blur-xs flex items-center justify-center z-50">
    <div class="bg-white p-6 rounded-lg shadow-lg w-1/3">
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

{{-- Modal Detail Paket Device --}}
<div id="modalDetailPaket"
    class="invisible fixed inset-0 bg-white/10 backdrop-blur-xs flex items-center justify-center z-50">
    <div class="bg-white p-6 rounded-lg shadow-lg w-1/3">
        <h2 class="text-sm font-bold">Detail Billing</h2>

        <div class="border border-black rounded-md p-3 mt-2 text-sm">
            <p id="">Device:</p>
            <p id="">Paket:</p>
            <p id="">Durasi:</p>
        </div>

        <p class="mt-3 text-sm">Apakah Anda yakin ingin memulai billing dengan Paket Ini?</p>

        <div class="justify-center w-full mt-4 space-x-2">
            <button class="w-full bg-[#3E81AB] text-white px-4 py-2 rounded text-xs mb-2"
                onclick="openModalPilihPaket(true)">Tambah Billing</button>
            <button id="btnKonfirmasi" class="w-full bg-[#FB2C36] text-white px-4 py-2 rounded text-xs"
                onclick="closeModal('modalDetailPaket')">STOP</button>
        </div>
    </div>
</div>

<script>
    function openModal(modalToShow, modalToHide = null) {
        if (modalToHide) {
            document.getElementById(modalToHide).classList.add("invisible");
        }
        document.getElementById(modalToShow).classList.remove("invisible");
    }

    function closeModal(modalToHide) {
        document.getElementById(modalToHide).classList.add("invisible");

        if (modalToHide === "modalPilihPaket") {
            resetPilihPaket();
        }
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

    let isTambahBilling = false;

    function openModalPilihPaket(isTambah) {
        isTambahBilling = isTambah;
        let deviceId;
        
        if (isTambah) {
            // Get device ID from konfirmasi button when adding to existing billing
            deviceId = document.getElementById('btnKonfirmasi').getAttribute('data-device-id');
            closeModal('modalDetailPaket');
        } else {
            // Get device ID from start billing button for new billing
            let selectedDevice = document.querySelector(".btn-start-billing[data-device-id]");
            deviceId = selectedDevice ? selectedDevice.getAttribute("data-device-id") : null;
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

            // Determine which endpoint to use based on whether we're adding to existing billing
            const endpoint = isAdding ? "{{ route('billing.add') }}" : "{{ route('billing.start') }}";

            // Log request data for debugging
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
                    let message = isAdding ? "Billing berhasil ditambahkan!" : "Billing telah dimulai!";
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
                alert(error.message || "Terjadi kesalahan saat memulai billing. Silakan coba lagi.");
            });
        });
    });

    function openModalDetailPaket(deviceId, deviceName, shutdownTime) {
        // Update modal content with device details
        document.getElementById('modalDetailPaket').querySelector('p:nth-child(1)').innerHTML = `Device: <span class="font-semibold">${deviceName}</span>`;
        document.getElementById('modalDetailPaket').querySelector('p:nth-child(3)').innerHTML = `Durasi: <span class="font-semibold">${shutdownTime}</span>`;
        
        // Store device ID for later use
        document.getElementById('btnKonfirmasi').setAttribute('data-device-id', deviceId);
        
        openModal('modalDetailPaket');
    }
</script>
