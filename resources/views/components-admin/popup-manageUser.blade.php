{{-- Tambah Modal --}}
<div id="modalAddPengguna" class="invisible fixed inset-0 bg-black/50 flex items-center justify-center z-50 px-4">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-sm md:max-w-md">
        <h2 class="text-center text-lg font-semibold mb-4">Tambah Pengguna</h2>

        <form action="{{ route('admin.manageUser.store') }}" method="POST">
            @csrf
            <div class="flex flex-col gap-2">
                <label class="text-sm font-medium text-[#656565]">Nama Pengguna</label>
                <input type="text" name="name" placeholder="Masukkan Nama Pengguna"
                    class="border rounded p-2 w-full text-sm border-[#9D9D9D]" required>

                <label class="text-sm font-medium text-[#656565]">Email</label>
                <input type="email" name="email" placeholder="Masukkan Email Pengguna"
                    class="border rounded p-2 w-full text-sm border-[#9D9D9D]" required>

                <label class="text-sm font-medium text-[#656565]">Password</label>
                <input type="password" name="password" placeholder="Masukkan Password Pengguna"
                    class="border rounded p-2 w-full text-sm border-[#9D9D9D]" required>

                <label class="text-sm font-medium text-[#656565]">No Telp</label>
                <input type="tel" name="phone_number" placeholder="08123456789"
                    class="border rounded p-2 w-full text-sm border-[#9D9D9D]" required>

                <label class="text-sm font-medium text-[#656565]">Alamat</label>
                <input type="text" name="address" placeholder="Jl. Alamat No. X"
                    class="border rounded p-2 w-full text-sm border-[#9D9D9D]" required>

            </div>

            <div class="flex justify-end mt-4">
                <button type="button" onclick="closeModal('modalAddPengguna')"
                    class="bg-[#C6C6C6] text-[#4F4F4F] px-4 py-2 rounded text-sm mr-2">Batal</button>
                <button type="submit" class="bg-[#3E81AB] text-white px-4 py-2 rounded text-sm">Simpan</button>
            </div>
        </form>
    </div>
</div>

{{-- Edit Modal --}}
<div id="modalEditPengguna" class="invisible fixed inset-0 bg-black/50 flex items-center justify-center z-50 px-4">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-sm md:max-w-md">
        <h2 class="text-center text-lg font-semibold mb-4">Detail Pengguna</h2>

        <form id="editUserForm" action="" method="POST">
            @csrf
            @method('PUT')
            <div class="flex flex-col gap-2">
                <label class="text-sm font-medium text-[#656565]">Nama Pengguna</label>
                <input type="text" name="name" id="edit_name" placeholder="Masukkan Nama Pengguna"
                    class="border rounded p-2 w-full text-sm border-[#9D9D9D]" required>

                <label class="text-sm font-medium text-[#656565]">Email</label>
                <input type="email" name="email" id="edit_email" placeholder="Masukkan Email Pengguna"
                    class="border rounded p-2 w-full text-sm border-[#9D9D9D]" required>

                <label class="text-sm font-medium text-[#656565]">Password</label>
                <input type="password" name="password" placeholder="Kosongkan jika tidak ingin mengubah password"
                    class="border rounded p-2 w-full text-sm border-[#9D9D9D]">

                <label class="text-sm font-medium text-[#656565]">No Telp</label>
                <input type="tel" name="phone_number" id="edit_phone_number" placeholder="08123456789"
                    class="border rounded p-2 w-full text-sm border-[#9D9D9D]" required>

                <label class="text-sm font-medium text-[#656565]">Alamat</label>
                <input type="text" name="address" id="edit_address" placeholder="Jl. Alamat No. X"
                    class="border rounded p-2 w-full text-sm border-[#9D9D9D]" required>

            </div>

            <div class="flex justify-between mt-4">
                <button type="button" onclick="openDeleteConfirmation()"
                    class="bg-[#FF4747] text-white px-4 py-2 rounded text-sm">Hapus</button>
                <div class="flex gap-2">
                    <button type="button" onclick="closeModal('modalEditPengguna')"
                        class="bg-[#C6C6C6] text-[#4F4F4F] px-4 py-2 rounded text-sm">Batal</button>
                    <button type="submit" class="bg-[#3E81AB] text-white px-4 py-2 rounded text-sm">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- Konfirmasi Hapus Modal --}}
<div id="modalKonfirmasiPengguna"
    class="invisible fixed inset-0 bg-black/50 flex items-center justify-center z-50 px-4">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-sm md:max-w-md">
        <h2 class="text-sm font-bold">Konfirmasi Hapus Data Pengguna</h2>
        <p class="mt-2 text-sm">Apakah Anda yakin ingin menghapus data pengguna <span id="delete_user_name"
                class="text-[#FF4747] font-semibold"></span> ini?</p>

        <form id="deleteUserForm" action="" method="POST">
            @csrf
            @method('DELETE')
            <div class="flex justify-center w-full mt-4 space-x-2">
                <button type="button" class="w-full bg-[#C6C6C6] text-[#4E4E4E] px-4 py-2 rounded text-xs"
                    onclick="closeModal('modalKonfirmasiPengguna')">Tidak, Kembali</button>
                <button type="submit" class="w-full bg-[#FF4747] text-white px-4 py-2 rounded text-xs">Ya, Hapus
                    Pengguna Ini</button>
            </div>
        </form>
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

    function editUser(id, name, email, phone_number, address, role_id) {
        // Set form action for update
        document.getElementById('editUserForm').action = "{{ route('admin.manageUser.update', '') }}/" + id;

        // Fill form fields with user data
        document.getElementById('edit_name').value = name;
        document.getElementById('edit_email').value = email;
        document.getElementById('edit_phone_number').value = phone_number;
        document.getElementById('edit_address').value = address;

        // Set delete form data
        document.getElementById('deleteUserForm').action = "{{ route('admin.manageUser.destroy', '') }}/" + id;
        document.getElementById('delete_user_name').textContent = name;

        // Open the edit modal
        openModal('modalEditPengguna');
    }

    function openDeleteConfirmation() {
        closeModal('modalEditPengguna');
        openModal('modalKonfirmasiPengguna');
    }
</script>
