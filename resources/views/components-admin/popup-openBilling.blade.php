{{-- Tambah --}}
<div id="modalAddPromo" class="invisible fixed inset-0 bg-black/50 flex items-center justify-center z-50 px-4">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-sm md:max-w-md">
        <h2 class="text-center text-lg font-semibold mb-4">Tambah Promo Open</h2>
        
        <div class="flex flex-col gap-2">            
            <label class="text-sm font-medium text-[#656565]">Durasi Promo</label>
            <div class="flex gap-2">
                <input type="number" placeholder="Jam" class="border rounded p-2 w-1/2 text-sm text-[#9D9D9D]">
                <input type="number" placeholder="Menit" class="border rounded p-2 w-1/2 text-sm text-[#9D9D9D]">
            </div>
            
            <label class="text-sm font-medium text-[#656565]">Diskon (Rp)</label>
            <input type="number" placeholder="Contoh: 24000" class="border rounded p-2 w-full text-sm text-[#9D9D9D]">
        </div>
        
        <div class="flex justify-end mt-4">
            <button onclick="closeModal('modalAddPromo')" class="bg-[#C6C6C6] text-[#4F4F4F] px-4 py-2 rounded text-sm mr-2">Batal</button>
            <button onclick="savePackage()" class="bg-[#3E81AB] text-white px-4 py-2 rounded text-sm">Simpan</button>
        </div>
    </div>
</div>

{{-- Edit --}}
<div id="modalEditPromo" class="invisible fixed inset-0 bg-black/50 flex items-center justify-center z-50 px-4">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-sm md:max-w-md">
        <h2 class="text-center text-lg font-semibold mb-4">Detail Promo Open</h2>
        
        <div class="flex flex-col gap-2">            
            <label class="text-sm font-medium text-[#656565]">Durasi Promo</label>
            <div class="flex gap-2">
                <input type="number" placeholder="Jam" class="border rounded p-2 w-1/2 text-sm text-[#9D9D9D]">
                <input type="number" placeholder="Menit" class="border rounded p-2 w-1/2 text-sm text-[#9D9D9D]">
            </div>
            
            <label class="text-sm font-medium text-[#656565]">Diskon (Rp)</label>
            <input type="number" placeholder="Contoh: 24000" class="border rounded p-2 w-full text-sm text-[#9D9D9D]">
        </div>
        
        <div class="flex justify-between mt-4">
            <button onclick="openModal('modalKonfirmasi', 'modalEditPromo')" class="bg-[#FF4747] text-white px-4 py-2 rounded text-sm">Hapus</button>
            <div class="flex gap-2">
                <button onclick="closeModal('modalEditPromo')" class="bg-[#C6C6C6] text-[#4F4F4F] px-4 py-2 rounded text-sm">Batal</button>
                <button onclick="savePackage()" class="bg-[#3E81AB] text-white px-4 py-2 rounded text-sm">Simpan</button>
            </div>
        </div>
    </div>
</div>

{{-- Konfirmasi --}}
<div id="modalKonfirmasi" class="invisible fixed inset-0 bg-black/50 flex items-center justify-center z-50 px-4">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-sm md:max-w-md">
        <h2 class="text-sm font-bold">Konfirmasi Hapus Promo Open</h2>
        <p class="mt-2 text-sm">Apakah Anda yakin ingin menghapus Promo Open Billing Ini?</p>

        <div class="flex justify-center w-full mt-4 space-x-2">
            <button class="w-full bg-[#C6C6C6] text-[#4E4E4E] px-4 py-2 rounded text-xs"
                onclick="closeModal('modalKonfirmasi')">Tidak, Kembali</button>
            <button onclick="" class="w-full bg-[#FF4747] text-white px-4 py-2 rounded text-xs">Ya, Hapus Promo Ini</button>
        </div>
    </div>
</div>


<script>
    function openModal(modalToShow, modalToHide = null) {
        if (modalToHide) {
            document.getElementById(modalToHide).classList.add("invisible");
        }
        const modal = document.getElementById(modalToShow);
        modal.classList.remove("invisible");
    }

    function closeModal(modalToHide) {
        document.getElementById(modalToHide).classList.add("invisible");
    }
</script>
    