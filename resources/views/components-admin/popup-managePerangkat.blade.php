{{-- Tambah --}}
<div id="modalAddPerangkat" class="invisible fixed inset-0 bg-black/50 flex items-center justify-center z-50 px-4">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-sm md:max-w-md">
        <h2 class="text-center text-lg font-semibold mb-4">Tambah Perangkat</h2>

        <form action="{{ route('admin.devices.store') }}" method="POST" class="flex flex-col gap-2">
            @csrf
            <label class="text-sm font-medium text-[#656565]">Nama Perangkat</label>
            <input type="text" name="name" placeholder="Masukkan Nama Perangkat"
                class="border rounded p-2 w-full text-sm text-black" required>

            <label class="text-sm font-medium text-[#656565]">Lokasi</label>
            <input type="text" name="location" placeholder="Contoh: Ruangan 1, Lantai 1"
                class="border rounded p-2 w-full text-sm text-black" required>

            <label class="text-sm font-medium text-[#656565]">IP Address</label>
            <input type="text" name="ip_address" placeholder="192.168.x.x"
                class="border rounded p-2 w-full text-sm text-black" required>

            <div class="flex justify-end mt-4">
                <button type="button" onclick="closeModal('modalAddPerangkat')"
                    class="bg-[#C6C6C6] text-[#4F4F4F] px-4 py-2 rounded text-sm mr-2 hover:bg-[#B5B5B5] cursor-pointer">Batal</button>
                <button type="submit"
                    class="bg-[#3E81AB] text-white px-4 py-2 rounded text-sm hover:bg-[#357396] cursor-pointer">Simpan</button>
            </div>
        </form>
    </div>
</div>

{{-- Edit --}}
<div id="modalEditPerangkat" class="invisible fixed inset-0 bg-black/50 flex items-center justify-center z-50 px-4">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-sm md:max-w-md">
        <h2 class="text-center text-lg font-semibold mb-4">Detail Perangkat</h2>

        <form id="editDeviceForm" method="POST" class="flex flex-col gap-2">
            @csrf
            @method('PUT')
            <label class="text-sm font-medium text-[#656565]">Nama Perangkat</label>
            <input type="text" name="name" id="editDeviceName" placeholder="Masukkan Nama Perangkat"
                class="border rounded p-2 w-full text-sm text-black" required>

            <label class="text-sm font-medium text-[#656565]">Lokasi</label>
            <input type="text" name="location" id="editDeviceLocation" placeholder="Contoh: Ruangan 1, Lantai 1"
                class="border rounded p-2 w-full text-sm text-black" required>

            <label class="text-sm font-medium text-[#656565]">IP Address</label>
            <input type="text" name="ip_address" id="editDeviceIpAddress" placeholder="192.168.x.x"
                class="border rounded p-2 w-full text-sm text-black" required>

            <div class="flex justify-between mt-4">
                <button type="button" onclick="openDeviceDeleteModal({{ $device }})"
                    class="bg-[#FF4747] text-white px-4 py-2 rounded text-sm hover:bg-[#E03E3E] cursor-pointer">Hapus</button>
                <div class="flex gap-2">
                    <button type="button" onclick="closeModal('modalEditPerangkat')"
                        class="bg-[#C6C6C6] text-[#4F4F4F] px-4 py-2 rounded text-sm hover:bg-[#B5B5B5] cursor-pointer">Batal</button>
                    <button type="submit"
                        class="bg-[#3E81AB] text-white px-4 py-2 rounded text-sm hover:bg-[#357396] cursor-pointer">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- Konfirmasi --}}
<div id="modalKonfirmasiPerangkat"
    class="invisible fixed inset-0 bg-black/50 flex items-center justify-center z-50 px-4">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-sm md:max-w-md">
        <h2 class="text-sm font-bold">Konfirmasi Hapus Data Perangkat</h2>
        <p class="mt-2 text-sm">Apakah Anda yakin ingin menghapus data perangkat <span id="deleteDeviceName"
                class="text-[#FF4747] font-semibold"></span> ini?</p>

        <form id="deleteDeviceForm" method="POST" class="flex justify-center w-full mt-4 space-x-2">
            @csrf
            @method('DELETE')
            <button type="button"
                class="w-full bg-[#C6C6C6] text-[#4E4E4E] px-4 py-2 rounded text-xs hover:bg-[#B5B5B5] cursor-pointer"
                onclick="closeModal('modalKonfirmasiPerangkat')">Tidak, Kembali</button>
            <button type="submit"
                class="w-full bg-[#FF4747] text-white px-4 py-2 rounded text-xs hover:bg-[#E03E3E] cursor-pointer">Ya,
                Hapus Perangkat
                Ini</button>
        </form>
    </div>
</div>

<script>
    function openDeviceEditModal(device) {
        document.getElementById('editDeviceForm').action = `/admin/devices/${device.id}`;
        document.getElementById('editDeviceName').value = device.name;
        document.getElementById('editDeviceLocation').value = device.location;
        document.getElementById('editDeviceIpAddress').value = device.ip_address;
        openModal('modalEditPerangkat');
    }

    function openDeviceDeleteModal(device) {
        document.getElementById('deleteDeviceForm').action = `/admin/devices/${device.id}`;
        document.getElementById('deleteDeviceName').textContent = `"${device.name}"`;
        openModal('modalKonfirmasiPerangkat');
    }
</script>
