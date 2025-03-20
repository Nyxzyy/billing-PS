{{-- Tambah --}}
<div id="modalAddPaket" class="invisible fixed inset-0 bg-black/50 flex items-center justify-center z-50 px-4">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-sm md:max-w-md">
        <h2 class="text-center text-lg font-semibold mb-4">Tambah Paket</h2>
        
        <div class="flex flex-col gap-2">
            <label class="text-sm font-medium text-[#656565]">Nama Paket</label>
            <input type="text" placeholder="Nama Paket (misal: Regular, VIP)" class="border rounded p-2 w-full text-sm text-[#9D9D9D]">
            
            <label class="text-sm font-medium text-[#656565]">Durasi</label>
            <div class="flex gap-2">
                <input type="number" placeholder="Jam" class="border rounded p-2 w-1/2 text-sm text-[#9D9D9D]">
                <input type="number" placeholder="Menit" class="border rounded p-2 w-1/2 text-sm text-[#9D9D9D]">
            </div>
            
            <label class="text-sm font-medium text-[#656565]">Harga Total (Rp)</label>
            <input type="number" placeholder="Contoh: 24000" class="border rounded p-2 w-full text-sm text-[#9D9D9D]">
            
            <label class="text-sm font-medium text-[#656565]">Pilih Hari</label>
            <div class="flex justify-between text-[#9D9D9D]">
                <button class="w-8 h-8 border rounded-full text-sm">S</button>
                <button class="w-8 h-8 border rounded-full text-sm">S</button>
                <button class="w-8 h-8 border rounded-full text-sm">R</button>
                <button class="w-8 h-8 border rounded-full text-sm">K</button>
                <button class="w-8 h-8 border rounded-full text-sm">J</button>
                <button class="w-8 h-8 border rounded-full text-sm">S</button>
                <button class="w-8 h-8 border rounded-full text-sm">M</button>
            </div>
            <button class="w-full border rounded py-2 text-sm text-[#9D9D9D]">Semua Hari</button>
        </div>
        
        <div class="flex justify-end mt-4">
            <button onclick="closeModal('modalAddPaket')" class="bg-[#C6C6C6] text-[#4F4F4F] px-4 py-2 rounded text-sm mr-2">Batal</button>
            <button onclick="savePackage()" class="bg-[#3E81AB] text-white px-4 py-2 rounded text-sm">Simpan</button>
        </div>
    </div>
</div>

{{-- Edit --}}
<div id="modalEditPaket" class="invisible fixed inset-0 bg-black/50 flex items-center justify-center z-50 px-4">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-sm md:max-w-md">
        <h2 class="text-center text-lg font-semibold mb-4">Detail Paket</h2>
        
        <div class="flex flex-col gap-2">
            <label class="text-sm font-medium text-[#656565]">Nama Paket</label>
            <input type="text" placeholder="Nama Paket (misal: Regular, VIP)" class="border rounded p-2 w-full text-sm text-[#9D9D9D]">
            
            <label class="text-sm font-medium text-[#656565]">Durasi</label>
            <div class="flex gap-2">
                <input type="number" placeholder="Jam" class="border rounded p-2 w-1/2 text-sm text-[#9D9D9D]">
                <input type="number" placeholder="Menit" class="border rounded p-2 w-1/2 text-sm text-[#9D9D9D]">
            </div>
            
            <label class="text-sm font-medium text-[#656565]">Harga Total (Rp)</label>
            <input type="number" placeholder="Contoh: 24000" class="border rounded p-2 w-full text-sm text-[#9D9D9D]">
            
            <label class="text-sm font-medium text-[#656565]">Pilih Hari</label>
            <div class="flex justify-between text-[#9D9D9D]">
                <button class="w-8 h-8 border rounded-full text-sm">S</button>
                <button class="w-8 h-8 border rounded-full text-sm">S</button>
                <button class="w-8 h-8 border rounded-full text-sm">R</button>
                <button class="w-8 h-8 border rounded-full text-sm">K</button>
                <button class="w-8 h-8 border rounded-full text-sm">J</button>
                <button class="w-8 h-8 border rounded-full text-sm">S</button>
                <button class="w-8 h-8 border rounded-full text-sm">M</button>
            </div>
            <button class="w-full border rounded py-2 text-sm text-[#9D9D9D]">Semua Hari</button>
        </div>
        
        <div class="flex justify-between mt-4">
            <button onclick="openModal('modalKonfirmasiPaket', 'modalEditPaket')" class="bg-[#FF4747] text-white px-4 py-2 rounded text-sm">Hapus</button>
            <div class="flex gap-2">
                <button onclick="closeModal('modalEditPaket')" class="bg-[#C6C6C6] text-[#4F4F4F] px-4 py-2 rounded text-sm">Batal</button>
                <button onclick="savePackage()" class="bg-[#3E81AB] text-white px-4 py-2 rounded text-sm">Simpan</button>
            </div>
        </div>
    </div>
</div>

{{-- Konfirmasi --}}
<div id="modalKonfirmasiPaket" class="invisible fixed inset-0 bg-black/50 flex items-center justify-center z-50 px-4">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-sm md:max-w-md">
        <h2 class="text-sm font-bold">Konfirmasi Hapus Paket Billing</h2>
        <p class="mt-2 text-sm">Apakah Anda yakin ingin menghapus Paket Billing <span class="text-[#FF4747] font-semibold">
            "Reguler"</span> ini?</p>

        <div class="flex justify-center w-full mt-4 space-x-2">
            <button class="w-full bg-[#C6C6C6] text-[#4E4E4E] px-4 py-2 rounded text-xs"
                onclick="closeModal('modalKonfirmasiPaket')">Tidak, Kembali</button>
            <button onclick="" class="w-full bg-[#FF4747] text-white px-4 py-2 rounded text-xs">Ya, Hapus Paket Ini</button>
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
    