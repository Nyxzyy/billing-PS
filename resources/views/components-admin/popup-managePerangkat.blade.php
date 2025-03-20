{{-- Tambah --}}
<div id="modalAddPerangkat" class="invisible fixed inset-0 bg-black/50 flex items-center justify-center z-50 px-4">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-sm md:max-w-md">
        <h2 class="text-center text-lg font-semibold mb-4">Tambah Perangkat</h2>
        
        <div class="flex flex-col gap-2">
            <label class="text-sm font-medium text-[#656565]">Nama Perangkat</label>
            <input type="text" placeholder="Masukkan Nama Perangkat" class="border rounded p-2 w-full text-sm text-[#9D9D9D]">

            <label class="text-sm font-medium text-[#656565]">Lokasi</label>
            <input type="text" placeholder="Contoh: Ruangan 1, Lantai 1" class="border rounded p-2 w-full text-sm text-[#9D9D9D]">

            <label class="text-sm font-medium text-[#656565]">IP Address</label>
            <input type="text" placeholder="192.168.x.x" class="border rounded p-2 w-full text-sm text-[#9D9D9D]">
        </div>
        
        <div class="flex justify-end mt-4">
            <button onclick="closeModal('modalAddPerangkat')" class="bg-[#C6C6C6] text-[#4F4F4F] px-4 py-2 rounded text-sm mr-2">Batal</button>
            <button onclick="savePackage()" class="bg-[#3E81AB] text-white px-4 py-2 rounded text-sm">Simpan</button>
        </div>
    </div>
</div>

{{-- Edit --}}
<div id="modalEditPerangkat" class="invisible fixed inset-0 bg-black/50 flex items-center justify-center z-50 px-4">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-sm md:max-w-md">
        <h2 class="text-center text-lg font-semibold mb-4">Detail Perangkat</h2>
        
        <div class="flex flex-col gap-2">
            <label class="text-sm font-medium text-[#656565]">Nama Perangkat</label>
            <input type="text" placeholder="Masukkan Nama Perangkat" class="border rounded p-2 w-full text-sm text-[#9D9D9D]">

            <label class="text-sm font-medium text-[#656565]">Lokasi</label>
            <input type="text" placeholder="Contoh: Ruangan 1, Lantai 1" class="border rounded p-2 w-full text-sm text-[#9D9D9D]">

            <label class="text-sm font-medium text-[#656565]">IP Address</label>
            <input type="text" placeholder="192.168.x.x" class="border rounded p-2 w-full text-sm text-[#9D9D9D]">
        </div>
        
        <div class="flex justify-between mt-4">
            <button onclick="openModal('modalKonfirmasi', 'modalEditPerangkat')" class="bg-[#FF4747] text-white px-4 py-2 rounded text-sm">Hapus</button>
            <div class="flex gap-2">
                <button onclick="closeModal('modalEditPerangkat')" class="bg-[#C6C6C6] text-[#4F4F4F] px-4 py-2 rounded text-sm">Batal</button>
                <button onclick="savePackage()" class="bg-[#3E81AB] text-white px-4 py-2 rounded text-sm">Simpan</button>
            </div>
        </div>
    </div>
</div>

{{-- Konfirmasi --}}
<div id="modalKonfirmasi" class="invisible fixed inset-0 bg-black/50 flex items-center justify-center z-50 px-4">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-sm md:max-w-md">
        <h2 class="text-sm font-bold">Konfirmasi Hapus Data Perangkat</h2>
        <p class="mt-2 text-sm">Apakah Anda yakin ingin menghapus data perangkat <span class="text-[#FF4747] font-semibold">
            "PS 1"</span> ini?</p>

        <div class="flex justify-center w-full mt-4 space-x-2">
            <button class="w-full bg-[#C6C6C6] text-[#4E4E4E] px-4 py-2 rounded text-xs"
                onclick="closeModal('modalKonfirmasi')">Tidak, Kembali</button>
            <button onclick="" class="w-full bg-[#FF4747] text-white px-4 py-2 rounded text-xs">Ya, Hapus Perangkat Ini</button>
        </div>
    </div>
</div>


<script>
    function openModal(modalId, closeModalId = null) {
        if (closeModalId) {
            document.getElementById(closeModalId).classList.add("invisible");
        }
        document.getElementById(modalId).classList.remove("invisible");
    }
    
    function closeModal(modalId) {
        document.getElementById(modalId).classList.add("invisible");
    }
</script>
    