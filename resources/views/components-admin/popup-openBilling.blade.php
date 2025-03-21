{{-- Tambah --}}
<div id="modalAddPromo" class="invisible fixed inset-0 bg-black/50 flex items-center justify-center z-50 px-4">
    <form action="{{ route('admin.openBilling.storePromo') }}" method="POST"
        class="bg-white p-6 rounded-lg shadow-lg w-full max-w-sm md:max-w-md">
        @csrf
        <h2 class="text-center text-lg font-semibold mb-4">Tambah Promo Open</h2>
        <div class="flex flex-col gap-2">
            <label class="text-sm font-medium text-[#656565]">Durasi Promo</label>
            <div class="flex gap-2">
                <input type="number" name="min_hours" placeholder="Jam"
                    class="border rounded p-2 w-1/2 text-sm text-[#9D9D9D]" required>
                <input type="number" name="min_minutes" placeholder="Menit"
                    class="border rounded p-2 w-1/2 text-sm text-[#9D9D9D]" required>
            </div>
            <label class="text-sm font-medium text-[#656565]">Diskon (Rp)</label>
            <input type="number" name="discount_price" placeholder="Contoh: 24000"
                class="border rounded p-2 w-full text-sm text-[#9D9D9D]" required>
        </div>
        <div class="flex justify-end mt-4">
            <button type="button" onclick="closeModal('modalAddPromo')"
                class="bg-[#C6C6C6] text-[#4F4F4F] px-4 py-2 rounded text-sm mr-2 hover:bg-[#B5B5B5] hover:text-[#3E3E3E] cursor-pointer">Batal</button>
            <button type="submit"
                class="bg-[#3E81AB] text-white px-4 py-2 rounded text-sm hover:bg-[#337399] hover:text-[#E6E6E6] cursor-pointer">Simpan</button>
        </div>
    </form>
</div>

{{-- Edit --}}
<div id="modalEditPromo" class="invisible fixed inset-0 bg-black/50 flex items-center justify-center z-50 px-4">
    <form id="formEditPromo" method="POST" class="bg-white p-6 rounded-lg shadow-lg w-full max-w-sm md:max-w-md">
        @csrf
        @method('PUT')
        <h2 class="text-center text-lg font-semibold mb-4">Edit Promo Open</h2>
        <div class="flex flex-col gap-2">
            <label class="text-sm font-medium text-[#656565]">Durasi Promo</label>
            <div class="flex gap-2">
                <input type="number" name="min_hours" id="edit_min_hours" placeholder="Jam"
                    class="border rounded p-2 w-1/2 text-sm text-[#9D9D9D]" required>
                <input type="number" name="min_minutes" id="edit_min_minutes" placeholder="Menit"
                    class="border rounded p-2 w-1/2 text-sm text-[#9D9D9D]" required>
            </div>
            <label class="text-sm font-medium text-[#656565]">Diskon (Rp)</label>
            <input type="number" name="discount_price" id="edit_discount_price" placeholder="Contoh: 24000"
                class="border rounded p-2 w-full text-sm text-[#9D9D9D]" required>
        </div>
        <div class="flex justify-end mt-4">
            {{-- <button type="button" onclick="openModal('modalKonfirmasiPromo', 'modalEditPromo')"
                class="bg-[#FF4747] text-white px-4 py-2 rounded text-sm">Hapus</button> --}}
            <div class="flex gap-2">
                <button type="button" onclick="closeModal('modalEditPromo')"
                    class="bg-[#C6C6C6] text-[#4F4F4F] px-4 py-2 rounded text-sm hover:bg-[#B5B5B5] hover:text-[#3E3E3E] cursor-pointer">Batal</button>
                <button type="submit"
                    class="bg-[#3E81AB] text-white px-4 py-2 rounded text-sm hover:bg-[#337399] hover:text-[#E6E6E6] cursor-pointer">Simpan</button>
            </div>
        </div>
    </form>
</div>

{{-- Konfirmasi --}}
<div id="modalKonfirmasiPromo" class="invisible fixed inset-0 bg-black/50 flex items-center justify-center z-50 px-4">
    <form id="formDeletePromo" method="POST" class="bg-white p-6 rounded-lg shadow-lg w-full max-w-sm md:max-w-md">
        @csrf
        @method('DELETE')
        <h2 class="text-sm font-bold">Konfirmasi Hapus Promo Open</h2>
        <p class="mt-2 text-sm">Apakah Anda yakin ingin menghapus Promo Open Billing Ini?</p>
        <div class="flex justify-center w-full mt-4 space-x-2">
            <button type="button"
                class="w-full bg-[#C6C6C6] text-[#4E4E4E] px-4 py-2 rounded text-xs hover:bg-[#B5B5B5] hover:text-[#3E3E3E] cursor-pointer"
                onclick="closeModal('modalKonfirmasiPromo')">Tidak, Kembali</button>
            <button type="submit"
                class="w-full bg-[#FF4747] text-white px-4 py-2 rounded text-xs hover:bg-[#E03E3E] hover:text-[#F5F5F5] cursor-pointer">Ya,
                Hapus Promo
                Ini</button>
        </div>
    </form>
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

    function openEditModal(promo) {
        document.getElementById('formEditPromo').action = `/admin/openBilling/updatePromo/${promo.id}`;
        document.getElementById('edit_min_hours').value = promo.min_hours;
        document.getElementById('edit_min_minutes').value = promo.min_minutes;
        document.getElementById('edit_discount_price').value = promo.discount_price;
        openModal('modalEditPromo');
    }

    function openDeleteModal(promoId) {
        document.getElementById('formDeletePromo').action = `/admin/openBilling/deletePromo/${promoId}`;
        openModal('modalKonfirmasiPromo');
    }
</script>
