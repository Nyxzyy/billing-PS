{{-- Tambah --}}
<div id="modalAddPengguna" class="invisible fixed inset-0 bg-black/50 flex items-center justify-center z-50 px-4">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-sm md:max-w-md">
        <h2 class="text-center text-lg font-semibold mb-4">Tambah Pengguna</h2>
        
        <div class="flex flex-col gap-2">
            <label class="text-sm font-medium text-[#656565]">Nama Pengguna</label>
            <input type="text" placeholder="Masukkan Nama Pengguna" class="border rounded p-2 w-full text-sm border-[#9D9D9D]">
            
            <label class="text-sm font-medium text-[#656565]">Email</label>
            <input type="email" placeholder="Masukkan Email Pengguna" class="border rounded p-2 w-full text-sm border-[#9D9D9D]">
            
            <label class="text-sm font-medium text-[#656565]">Password</label>
            <input type="password" placeholder="Masukkan Password Pengguna" class="border rounded p-2 w-full text-sm border-[#9D9D9D]">
            
            <label class="text-sm font-medium text-[#656565]">No Telp</label>
            <input type="tel" placeholder="08123456789" class="border rounded p-2 w-full text-sm border-[#9D9D9D]">
            
            <label class="text-sm font-medium text-[#656565]">Alamat</label>
            <input type="text" placeholder="Jl. Alamat No. X" class="border rounded p-2 w-full text-sm border-[#9D9D9D]">
        </div>
        
        <div class="flex justify-end mt-4">
            <button onclick="closeModal('modalAddPengguna')" class="bg-[#C6C6C6] text-[#4F4F4F] px-4 py-2 rounded text-sm mr-2">Batal</button>
            <button onclick="savePackage()" class="bg-[#3E81AB] text-white px-4 py-2 rounded text-sm">Simpan</button>
        </div>
    </div>
</div>

{{-- Edit --}}
<div id="modalEditPengguna" class="invisible fixed inset-0 bg-black/50 flex items-center justify-center z-50 px-4">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-sm md:max-w-md">
        <h2 class="text-center text-lg font-semibold mb-4">Detail Pengguna</h2>
        
        <div class="flex flex-col gap-2">
            <label class="text-sm font-medium text-[#656565]">Nama Pengguna</label>
            <input type="text" placeholder="Masukkan Nama Pengguna" class="border rounded p-2 w-full text-sm border-[#9D9D9D]">
            
            <label class="text-sm font-medium text-[#656565]">Email</label>
            <input type="email" placeholder="Masukkan Email Pengguna" class="border rounded p-2 w-full text-sm border-[#9D9D9D]">
            
            <label class="text-sm font-medium text-[#656565]">Password</label>
            <input type="password" placeholder="Masukkan Password Pengguna" class="border rounded p-2 w-full text-sm border-[#9D9D9D]">
            
            <label class="text-sm font-medium text-[#656565]">No Telp</label>
            <input type="tel" placeholder="08123456789" class="border rounded p-2 w-full text-sm border-[#9D9D9D]">
            
            <label class="text-sm font-medium text-[#656565]">Alamat</label>
            <input type="text" placeholder="Jl. Alamat No. X" class="border rounded p-2 w-full text-sm border-[#9D9D9D]">
        </div>
        
        <div class="flex justify-between mt-4">
            <button onclick="openModal('modalKonfirmasiPengguna', 'modalEditPengguna')" class="bg-[#FF4747] text-white px-4 py-2 rounded text-sm">Hapus</button>
            <div class="flex gap-2">
                <button onclick="closeModal('modalEditPengguna')" class="bg-[#C6C6C6] text-[#4F4F4F] px-4 py-2 rounded text-sm">Batal</button>
                <button onclick="savePackage()" class="bg-[#3E81AB] text-white px-4 py-2 rounded text-sm">Simpan</button>
            </div>
        </div>
    </div>
</div>

{{-- Konfirmasi --}}
<div id="modalKonfirmasiPengguna" class="invisible fixed inset-0 bg-black/50 flex items-center justify-center z-50 px-4">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-sm md:max-w-md">
        <h2 class="text-sm font-bold">Konfirmasi Hapus Data Pengguna</h2>
        <p class="mt-2 text-sm">Apakah Anda yakin ingin menghapus data pengguna <span class="text-[#FF4747] font-semibold">
            "Abdullah Ali"</span> ini?</p>

        <div class="flex justify-center w-full mt-4 space-x-2">
            <button class="w-full bg-[#C6C6C6] text-[#4E4E4E] px-4 py-2 rounded text-xs"
                onclick="closeModal('modalKonfirmasiPengguna')">Tidak, Kembali</button>
            <button onclick="" class="w-full bg-[#FF4747] text-white px-4 py-2 rounded text-xs">Ya, Hapus Pengguna Ini</button>
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
    