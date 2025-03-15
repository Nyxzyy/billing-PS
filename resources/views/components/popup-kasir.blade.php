{{-- Modal Mulai Shift --}}
<div id="modalMulaiShift" class="invisible fixed inset-0 bg-white/10 backdrop-blur-xs flex items-center justify-center z-50 px-4">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-sm md:max-w-md">
        <h2 class="text-sm font-bold">Mulai Shift Kerja</h2>
        <p class="mt-2 text-sm text-[#545454]">Klik Tombol dibawah ini untuk memulai shift anda saat ini.</p>

        <div class="flex justify-center w-full mt-4 space-x-2">
            <button class="w-full bg-[#64DF64] text-white px-4 py-2 rounded text-xs">Mulai Shift</button>
        </div>
        <div class="border-t border-dashed border-[#DFDFDF] w-full mt-4 pt-2"></div>
    </div>
</div>

{{-- Modal Kendala --}}
<div id="modalKendala" class="invisible fixed inset-0 bg-white/10 backdrop-blur-xs flex items-center justify-center z-50 px-4">
    <div class="bg-white p-5 rounded-lg w-full max-w-sm md:max-w-md">
        <h2 class="text-sm font-bold text-center mb-4">Kendala Device</h2>
        <label class="text-xs text-[#656565]">Ketikkan Kendalanya</label>
        <textarea id="textareaKendala" class="w-full border border-[#C0C0C0] p-2 rounded mt-1" placeholder="Ketikkan Kendalanya..."></textarea>
        
        <div class="flex items-center mt-2">
            <input type="checkbox" id="konfirmasi" class="mr-2">
            <label for="konfirmasi" class="text-[#4E4E4E] text-xs">Konfirmasi Kunci Device</label>
        </div>

        <div class="flex justify-end mt-4">
            <button class="bg-[#C6C6C6] text-[#4E4E4E] px-4 py-2 rounded mr-2 text-xs" onclick="closeModalKendala()">Batal</button>
            <button id="btnKunci" class="bg-[#3E81AB] text-white px-4 py-2 rounded text-xs cursor-not-allowed" disabled onclick="openModalKunci()">Kunci</button>
        </div>
    </div>
</div>

<div id="modalKonfirmasiKunci" class="invisible fixed inset-0 bg-white/10 backdrop-blur-xs flex items-center justify-center z-50 px-4">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-sm md:max-w-md">
        <h2 class="text-sm font-bold">Konfirmasi Kunci Device</h2>
        <p class="mt-2 text-sm">Apakah Anda yakin ingin mengunci Device <span class="text-[#FF4747] font-semibold">"PS 2"</span> ini?</p>

        <div class="flex justify-center w-full mt-4 space-x-2">
            <button class="w-full bg-[#C6C6C6] text-[#4E4E4E] px-4 py-2 rounded mr-2 text-xs" onclick="closeModal('modalKonfirmasiKunci')">Tidak, Kembali</button>
            <button class="w-full bg-[#FF4747] text-white px-4 py-2 rounded text-xs">Kunci dan Laporkan</button>
        </div>
    </div>
</div>

{{-- Modal Detail Kendala --}}
<div id="modalDetailKendala" class="invisible fixed inset-0 bg-white/10 backdrop-blur-xs flex items-center justify-center z-50 px-4">
    <div class="bg-white p-5 rounded-lg w-full max-w-sm md:max-w-md">
        <h2 class="text-sm font-bold text-center mb-4">Detail Kendala Device</h2>
        <label class="text-xs text-[#656565]">Ketikkan Kendalanya</label>
        <textarea class="w-full border border-[#C0C0C0] p-2 rounded mt-1" placeholder="Ketikkan Kendalanya. . . ."></textarea>
        <div class="flex items-center">
            <input type="checkbox" id="konfirmasi" class="mr-2">
            <label for="konfirmasi" class="text-[#4E4E4E] text-xs">Konfirmasi Kunci Device</label>
        </div>

        <div class="flex justify-end mt-4">
            <button class="bg-[#C6C6C6] text-[#4E4E4E] px-4 py-2 rounded mr-2 text-xs" onclick="closeModal('modalDetailKendala')">Batal</button>
            <button class="bg-[#3E81AB] text-white px-4 py-2 rounded text-xs" onclick="openModal('modalBukaKunci', 'modalDetailKendala')">Buka</button>
        </div>
    </div>
</div>

<div id="modalBukaKunci" class="invisible fixed inset-0 bg-white/10 backdrop-blur-xs flex items-center justify-center z-50 px-4">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-sm md:max-w-md">
        <h2 class="text-sm font-bold ">Konfirmasi Buka Kunci Device</h2>
        <p class="mt-2 text-sm">Apakah Anda yakin ingin membuka kunci Device <span class="text-[#FF4747] font-semibold">"PS 2"</span> ini?</p>

        <div class="flex justify-center w-full mt-4 space-x-2">
            <button class="w-full bg-[#C6C6C6] text-[#4E4E4E] px-4 py-2 rounded mr-2 text-xs" onclick="closeModal('modalBukaKunci')">Tidak, Kembali</button>
            <button class="w-full bg-[#FF4747] text-white px-4 py-2 rounded text-xs">Buka Kunci</button>
        </div>
    </div>
</div>

{{-- Modal Pilih Paket --}}
<div id="modalPilihPaket" class="invisible fixed inset-0 bg-white/10 backdrop-blur-xs flex items-center justify-center z-50 px-4">
    <div class="bg-white p-5 rounded-lg w-full max-w-sm md:max-w-md shadow-lg">
        <h2 class="text-sm font-bold text-center mb-4">Pilih Paket Billing</h2>

        <label class="text-xs text-[#656565]">Pilih Paket</label>
        <select id="pilihPaket" class="w-full border border-[#C0C0C0] p-2 rounded mt-1 text-[#969696]">
            <option value="" disabled selected>Pilih Paket</option>
            <option value="paket1">Paket Main 2 Jam - Rp. 10.000</option>
            <option value="paket2">Paket Main 5 Jam - Rp. 30.000</option>
        </select>

        <div class="flex items-center mt-2">
            <input type="checkbox" id="openPaket" class="mr-2">
            <label for="openPaket" class="text-[#4E4E4E] text-xs">Open (Tanpa Batas Waktu)</label>
        </div>

        <div class="flex justify-end mt-4">
            <button class="bg-[#C6C6C6] text-[#4E4E4E] px-4 py-2 rounded mr-2 text-xs" onclick="closeModal('modalPilihPaket')">Batal</button>
            <button class="bg-[#3E81AB] text-white px-4 py-2 rounded text-xs" onclick="openModalKonfirmasi()">Lanjut</button>
        </div>
    </div>
</div>

{{-- Modal Konfirmasi Paket --}}
<div id="modalKonfirmasi" class="invisible fixed inset-0 bg-white/10 backdrop-blur-xs flex items-center justify-center z-50 px-4">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-sm md:max-w-md">
        <h2 class="text-sm font-bold">Konfirmasi Paket Billing</h2>

        <div class="border border-black rounded-md p-3 mt-2 text-sm">
            <p id="paketDetail"></p>
            <p id="hargaDetail"></p>
        </div>

        <p class="mt-3 text-sm">Apakah Anda yakin ingin memulai billing dengan Paket Ini?</p>

        <div class="flex justify-center w-full mt-4 space-x-2">
            <button class="w-full bg-[#C6C6C6] text-[#4E4E4E] px-4 py-2 rounded text-xs" onclick="closeModal('modalKonfirmasi')">Batal</button>
            <button id="btnKonfirmasi" class="w-full bg-[#64DF64] text-white px-4 py-2 rounded text-xs">Mulai</button>
        </div>
    </div>
</div>

{{-- Modal Detail Paket --}}
<div id="modalDetailPaket" class="invisible fixed inset-0 bg-white/10 backdrop-blur-xs flex items-center justify-center z-50 px-4">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-sm md:max-w-md">
        <h2 class="text-sm font-bold">Detail Billing</h2>

        <div class="border border-black rounded-md p-3 mt-2 text-sm">
            <p id="">Device:</p>
            <p id="">Paket:</p>
            <p id="">Durasi:</p>
        </div>

        <p class="mt-3 text-sm">Apakah Anda yakin ingin memulai billing dengan Paket Ini?</p>

        <div class="justify-center w-full mt-4 space-x-2">
            <button class="w-full bg-[#3E81AB] text-white px-4 py-2 rounded text-xs mb-2" onclick="openModalPilihPaket(true)">Tambah Billing</button>
            <button id="btnKonfirmasi" class="w-full bg-[#FB2C36] text-white px-4 py-2 rounded text-xs" onclick="closeModal('modalDetailPaket')">STOP</button>
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

        isTambahBilling = false;
        btnKonfirmasi.innerHTML = "Print Struk dan Mulai";
    }

    let isTambahBilling = false;
    function openModalPilihPaket(isTambah) {
        isTambahBilling = isTambah;

        closeModal("modalDetailPaket");

        let openCheckbox = document.getElementById("openPaket");
        let openLabel = document.querySelector("label[for='openPaket']");

        if (isTambahBilling) {
            openCheckbox.disabled = true;
            openLabel.style.color = "#D8D8D8"; 
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

        if (openCheckbox.checked) {
            paketDetail.innerHTML = "Paket: <span class='font-semibold'>Open (Tanpa Batas Waktu)</span>";
            hargaDetail.innerHTML = "Harga: <span class='font-semibold'>Dihitung di akhir</span>";
            teksKonfirmasi.innerHTML = "Apakah Anda yakin ingin memulai billing dengan paket <strong>Open (Tanpa Batas Waktu)?</strong>";
            btnKonfirmasi.innerHTML = "Mulai";
        } else if (paketDropdown.value === "paket1") {
            paketDetail.innerHTML = "Paket: <span class='font-semibold'>Paket Main 2 Jam</span>";
            hargaDetail.innerHTML = "Harga: <span class='font-semibold'>Rp. 10.000</span>";
            teksKonfirmasi.innerHTML = "Apakah Anda yakin ingin memulai billing dengan paket <strong>Paket Main 2 Jam?</strong>";
        } else if (paketDropdown.value === "paket2") {
            paketDetail.innerHTML = "Paket: <span class='font-semibold'>Paket Main 5 Jam</span>";
            hargaDetail.innerHTML = "Harga: <span class='font-semibold'>Rp. 30.000</span>";
            teksKonfirmasi.innerHTML = "Apakah Anda yakin ingin memulai billing dengan paket <strong>Paket Main 5 Jam?</strong>";
        } else {
            alert("Pilih paket terlebih dahulu!");
            return;
        }

        if (!openCheckbox.checked) {
            btnKonfirmasi.innerHTML = isTambahBilling ? "Print Struk dan Tambah" : "Print Struk dan Mulai";
        }

        closeModal("modalPilihPaket");
        openModal("modalKonfirmasi");
    }

    document.addEventListener("DOMContentLoaded", function () {
        let paketDropdown = document.getElementById("pilihPaket");
        let openCheckbox = document.getElementById("openPaket");
        let openLabel = document.querySelector("label[for='openPaket']");

        paketDropdown.addEventListener("change", function () {
            if (paketDropdown.value) {
                openCheckbox.disabled = true;
                openLabel.style.color = "#D8D8D8";
            } else {
                openCheckbox.disabled = false;
                openLabel.style.color = "#4E4E4E";
            }
        });

        openCheckbox.addEventListener("change", function () {
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

    document.addEventListener("DOMContentLoaded", function () {
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

        // Reset semua elemen ke default
        textareaKendala.value = "";
        konfirmasiCheckbox.checked = false;
        btnKunci.disabled = true;
        btnKunci.classList.add("cursor-not-allowed");
        btnKunci.classList.remove("cursor-pointer");
    }

</script>
