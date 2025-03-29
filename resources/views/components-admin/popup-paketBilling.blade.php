{{-- Tambah Paket Billing --}}
<div id="modalAddPaket" class="invisible fixed inset-0 bg-black/50 flex items-center justify-center z-50 px-4">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-sm md:max-w-md">
        <h2 class="text-center text-lg font-semibold mb-4">Tambah Paket</h2>
        <form action="{{ route('billing-packages.store') }}" method="POST" id="addPackageForm">
            @csrf
            <div class="flex flex-col gap-2">
                <label class="text-sm font-medium text-[#656565]">Nama Paket</label>
                <input type="text" name="package_name" placeholder="Nama Paket (misal: Regular, VIP)"
                    class="border rounded p-2 w-full text-sm text-black" required>

                <label class="text-sm font-medium text-[#656565]">Durasi</label>
                <div class="flex gap-2">
                    <input type="number" name="duration_hours" placeholder="Jam"
                        class="border rounded p-2 w-1/2 text-sm text-black" min="0" required>
                    <input type="number" name="duration_minutes" placeholder="Menit"
                        class="border rounded p-2 w-1/2 text-sm text-black" min="0" max="59" required>
                </div>

                <label class="text-sm font-medium text-[#656565]">Harga Total (Rp)</label>
                <input type="number" name="total_price" placeholder="Contoh: 24000"
                    class="border rounded p-2 w-full text-sm text-black" min="0" required>

                <label class="text-sm font-medium text-[#656565]">Pilih Hari</label>
                <!-- Hidden inputs untuk setiap hari yang akan di-toggle dengan JS -->
                <input type="hidden" name="active_days[]" value="Senin" id="add_day_Senin" disabled>
                <input type="hidden" name="active_days[]" value="Selasa" id="add_day_Selasa" disabled>
                <input type="hidden" name="active_days[]" value="Rabu" id="add_day_Rabu" disabled>
                <input type="hidden" name="active_days[]" value="Kamis" id="add_day_Kamis" disabled>
                <input type="hidden" name="active_days[]" value="Jumat" id="add_day_Jumat" disabled>
                <input type="hidden" name="active_days[]" value="Sabtu" id="add_day_Sabtu" disabled>
                <input type="hidden" name="active_days[]" value="Minggu" id="add_day_Minggu" disabled>

                <div class="flex justify-between text-black">
                    <button type="button" data-day="Senin"
                        class="day-btn border rounded-full w-8 h-8 flex items-center justify-center cursor-pointer hover:bg-[#3E81AB] hover:text-white">S</button>
                    <button type="button" data-day="Selasa"
                        class="day-btn border rounded-full w-8 h-8 flex items-center justify-center cursor-pointer hover:bg-[#3E81AB] hover:text-white">S</button>
                    <button type="button" data-day="Rabu"
                        class="day-btn border rounded-full w-8 h-8 flex items-center justify-center cursor-pointer hover:bg-[#3E81AB] hover:text-white">R</button>
                    <button type="button" data-day="Kamis"
                        class="day-btn border rounded-full w-8 h-8 flex items-center justify-center cursor-pointer hover:bg-[#3E81AB] hover:text-white">K</button>
                    <button type="button" data-day="Jumat"
                        class="day-btn border rounded-full w-8 h-8 flex items-center justify-center cursor-pointer hover:bg-[#3E81AB] hover:text-white">J</button>
                    <button type="button" data-day="Sabtu"
                        class="day-btn border rounded-full w-8 h-8 flex items-center justify-center cursor-pointer hover:bg-[#3E81AB] hover:text-white">S</button>
                    <button type="button" data-day="Minggu"
                        class="day-btn border rounded-full w-8 h-8 flex items-center justify-center cursor-pointer hover:bg-[#3E81AB] hover:text-white">M</button>
                </div>
                <div class="mt-2">
                    <button type="button"
                        class="w-full border rounded py-2 text-sm text-black cursor-pointer hover:bg-[#3E81AB] hover:text-white hover:border-[#3E81AB]"
                        onclick="selectAllDays('add')">Semua Hari</button>
                </div>

                <label class="text-sm font-medium text-[#656565]">Jam Aktif</label>
                <div class="flex gap-2">
                    <div class="w-1/2">
                        <input type="time" name="active_hours_start"
                            class="border rounded p-2 w-full text-sm text-black" required>
                    </div>
                    <div class="w-1/2">
                        <input type="time" name="active_hours_end"
                            class="border rounded p-2 w-full text-sm text-black" required>
                    </div>
                </div>
            </div>

            <div class="flex justify-end mt-4">
                <button type="button" onclick="closeModal('modalAddPaket')"
                    class="bg-[#C6C6C6] text-[#4F4F4F] px-4 py-2 rounded text-sm mr-2 cursor-pointer hover:bg-[#A9A9A9] hover:text-[#3E3E3E]">Batal</button>
                <button type="submit"
                    class="bg-[#3E81AB] text-white px-4 py-2 rounded text-sm cursor-pointer hover:bg-[#2C6A8E]">Simpan</button>
            </div>
        </form>
    </div>
</div>

{{-- Edit Paket Billing --}}
<div id="modalEditPaket" class="invisible fixed inset-0 bg-black/50 flex items-center justify-center z-50 px-4">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-sm md:max-w-md">
        <h2 class="text-center text-lg font-semibold mb-4">Edit Paket</h2>
        <form id="editPackageForm" method="POST">
            @csrf
            @method('PUT')
            <div class="flex flex-col gap-2">
                <label class="text-sm font-medium text-[#656565]">Nama Paket</label>
                <input type="text" name="package_name" id="edit_package_name"
                    placeholder="Nama Paket (misal: Regular, VIP)"
                    class="border rounded p-2 w-full text-sm text-black" required>

                <label class="text-sm font-medium text-[#656565]">Durasi</label>
                <div class="flex gap-2">
                    <input type="number" name="duration_hours" id="edit_duration_hours" placeholder="Jam"
                        class="border rounded p-2 w-1/2 text-sm text-black" min="0" required>
                    <input type="number" name="duration_minutes" id="edit_duration_minutes" placeholder="Menit"
                        class="border rounded p-2 w-1/2 text-sm text-black" min="0" max="59" required>
                </div>

                <label class="text-sm font-medium text-[#656565]">Harga Total (Rp)</label>
                <input type="number" name="total_price" id="edit_total_price" placeholder="Contoh: 24000"
                    class="border rounded p-2 w-full text-sm text-black" min="0" required>

                <label class="text-sm font-medium text-[#656565]">Pilih Hari</label>
                <!-- Hidden inputs untuk setiap hari yang akan di-toggle dengan JS -->
                <input type="hidden" name="active_days[]" value="Senin" id="edit_day_Senin" disabled>
                <input type="hidden" name="active_days[]" value="Selasa" id="edit_day_Selasa" disabled>
                <input type="hidden" name="active_days[]" value="Rabu" id="edit_day_Rabu" disabled>
                <input type="hidden" name="active_days[]" value="Kamis" id="edit_day_Kamis" disabled>
                <input type="hidden" name="active_days[]" value="Jumat" id="edit_day_Jumat" disabled>
                <input type="hidden" name="active_days[]" value="Sabtu" id="edit_day_Sabtu" disabled>
                <input type="hidden" name="active_days[]" value="Minggu" id="edit_day_Minggu" disabled>

                <div class="flex justify-between text-black">
                    <button type="button" data-day="Senin"
                        class="day-btn border rounded-full w-8 h-8 flex items-center justify-center cursor-pointer hover:bg-[#3E81AB] hover:text-white">S</button>
                    <button type="button" data-day="Selasa"
                        class="day-btn border rounded-full w-8 h-8 flex items-center justify-center cursor-pointer hover:bg-[#3E81AB] hover:text-white">S</button>
                    <button type="button" data-day="Rabu"
                        class="day-btn border rounded-full w-8 h-8 flex items-center justify-center cursor-pointer hover:bg-[#3E81AB] hover:text-white">R</button>
                    <button type="button" data-day="Kamis"
                        class="day-btn border rounded-full w-8 h-8 flex items-center justify-center cursor-pointer hover:bg-[#3E81AB] hover:text-white">K</button>
                    <button type="button" data-day="Jumat"
                        class="day-btn border rounded-full w-8 h-8 flex items-center justify-center cursor-pointer hover:bg-[#3E81AB] hover:text-white">J</button>
                    <button type="button" data-day="Sabtu"
                        class="day-btn border rounded-full w-8 h-8 flex items-center justify-center cursor-pointer hover:bg-[#3E81AB] hover:text-white">S</button>
                    <button type="button" data-day="Minggu"
                        class="day-btn border rounded-full w-8 h-8 flex items-center justify-center cursor-pointer hover:bg-[#3E81AB] hover:text-white">M</button>
                </div>
                <div class="mt-2">
                    <button type="button"
                        class="w-full border rounded py-2 text-sm text-black cursor-pointer hover:bg-[#3E81AB] hover:text-white hover:border-[#3E81AB]"
                        onclick="selectAllDays('edit')">Semua Hari</button>
                </div>

                <label class="text-sm font-medium text-[#656565]">Jam Aktif</label>
                <div class="flex gap-2">
                    <div class="w-1/2">
                        <input type="time" name="active_hours_start" id="edit_active_hours_start"
                            class="border rounded p-2 w-full text-sm text-black" required>
                    </div>
                    <div class="w-1/2">
                        <input type="time" name="active_hours_end" id="edit_active_hours_end"
                            class="border rounded p-2 w-full text-sm text-black" required>
                    </div>
                </div>
            </div>

            <div class="flex justify-between mt-4">
                <button type="button" onclick="openModal('modalKonfirmasiPaket', 'modalEditPaket')"
                    class="bg-[#FF4747] text-white px-4 py-2 rounded text-sm cursor-pointer hover:bg-[#D43C3C]">Hapus</button>
                <div class="flex gap-2">
                    <button type="button" onclick="closeModal('modalEditPaket')"
                        class="bg-[#C6C6C6] text-[#4F4F4F] px-4 py-2 rounded text-sm cursor-pointer hover:bg-[#A9A9A9] hover:text-[#3E3E3E]">Batal</button>
                    <button type="submit"
                        class="bg-[#3E81AB] text-white px-4 py-2 rounded text-sm cursor-pointer hover:bg-[#2C6A8E]">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- Konfirmasi Hapus Paket --}}
<div id="modalKonfirmasiPaket" class="invisible fixed inset-0 bg-black/50 flex items-center justify-center z-50 px-4">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-sm md:max-w-md">
        <h2 class="text-sm font-bold">Konfirmasi Hapus Paket Billing</h2>
        <p class="mt-2 text-sm">Apakah Anda yakin ingin menghapus Paket Billing <span id="deletePackageName"
                class="text-[#FF4747] font-semibold"></span>?</p>

        <div class="flex justify-center w-full mt-4 space-x-2">
            <button class="w-full bg-[#C6C6C6] text-[#4E4E4E] px-4 py-2 rounded text-xs  cursor-pointer"
                onclick="closeModal('modalKonfirmasiPaket')">Tidak, Kembali</button>
            <form id="deletePackageForm" method="POST" class="w-full">
                @csrf
                @method('DELETE')
                <button type="submit"
                    class="w-full bg-[#FF4747] text-white px-4 py-2 rounded text-xs  cursor-pointer">Ya, Hapus
                    Paket Ini</button>
            </form>
        </div>
    </div>
</div>

<script>
    function openModal(modalToShow, id = null, name = '', hours = 0, minutes = 0, price = 0, active_days = [],
        modalToHide = null, active_hours_start = '', active_hours_end = '') {
        if (modalToHide) {
            document.getElementById(modalToHide).classList.add("invisible");
        }

        const modal = document.getElementById(modalToShow);
        modal.classList.remove("invisible");

        // Jika ini adalah modal edit dan ada id (berarti sedang mengedit)
        if (modalToShow === 'modalEditPaket' && id !== null) {
            // Set form action dengan id package
            document.getElementById('editPackageForm').action =
                `{{ url('/admin/billingPackages/billing-packages') }}/${id}`;

            // Isi field dengan data
            document.getElementById('edit_package_name').value = name;
            document.getElementById('edit_duration_hours').value = hours;
            document.getElementById('edit_duration_minutes').value = minutes;
            document.getElementById('edit_total_price').value = price;

            // Parse active_days jika berbentuk string JSON
            let parsedDays = active_days;
            if (typeof active_days === 'string') {
                try {
                    parsedDays = JSON.parse(active_days);
                } catch (e) {
                    console.error('Error parsing active_days:', e);
                    parsedDays = [];
                }
            }

            // Aktifkan tombol hari sesuai data
            if (Array.isArray(parsedDays)) {
                parsedDays.forEach(day => {
                    const input = document.getElementById('edit_day_' + day);
                    const button = document.querySelector('#editPackageForm .day-btn[data-day="' + day + '"]');

                    if (input) {
                        input.disabled = false;
                    }
                    if (button) {
                        button.classList.add('bg-[#3E81AB]', 'text-white');
                    }
                });
            }

            // Untuk modal konfirmasi hapus
            document.getElementById('deletePackageName').textContent = name;
            document.getElementById('deletePackageForm').action =
                `{{ url('/admin/billingPackages/billing-packages') }}/${id}`;

            // Set jam aktif
            document.getElementById('edit_active_hours_start').value = active_hours_start;
            document.getElementById('edit_active_hours_end').value = active_hours_end;
        }
    }

    function closeModal(modalToHide) {
        document.getElementById(modalToHide).classList.add("invisible");

        // Reset state tombol hari jika yang ditutup adalah modal edit atau add
        if (modalToHide === 'modalEditPaket' || modalToHide === 'modalAddPaket') {
            const formType = modalToHide === 'modalEditPaket' ? 'edit' : 'add';
            const formId = formType === 'edit' ? 'editPackageForm' : 'addPackageForm';
            const prefix = formType === 'edit' ? 'edit_day_' : 'add_day_';
            const days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];

            // Reset semua input hidden
            days.forEach(day => {
                const input = document.getElementById(prefix + day);
                if (input) {
                    input.disabled = true;
                }
            });

            // Reset semua tombol hari
            document.querySelectorAll(`#${formId} .day-btn`).forEach(button => {
                button.classList.remove('bg-[#3E81AB]', 'text-white');
            });

            // Reset form jika ada
            const form = document.getElementById(formId);
            if (form) {
                form.reset();
            }
        }
    }

    function toggleDay(day, formType) {
        const prefix = formType === 'edit' ? 'edit_day_' : 'add_day_';
        const input = document.getElementById(prefix + day);

        if (input.disabled) {
            // Aktifkan input jika saat ini dinonaktifkan
            input.disabled = false;
        } else {
            // Nonaktifkan input jika saat ini diaktifkan
            input.disabled = true;
        }
    }

    function initializeDayButtons(formType) {
        const formId = formType === 'edit' ? 'editPackageForm' : 'addPackageForm';

        document.querySelectorAll(`#${formId} .day-btn`).forEach(button => {
            button.addEventListener('click', function() {
                const day = this.dataset.day;
                const prefix = formType === 'edit' ? 'edit_day_' : 'add_day_';
                const input = document.getElementById(prefix + day);

                if (this.classList.contains('bg-[#3E81AB]')) {
                    // Jika hari sudah dipilih, hapus dari daftar
                    this.classList.remove('bg-[#3E81AB]', 'text-white');
                    input.disabled = true;
                } else {
                    // Jika hari belum dipilih, tambahkan ke daftar
                    this.classList.add('bg-[#3E81AB]', 'text-white');
                    input.disabled = false;
                }
            });
        });
    }

    function selectAllDays(formType) {
        const formId = formType === 'edit' ? 'editPackageForm' : 'addPackageForm';
        const prefix = formType === 'edit' ? 'edit_day_' : 'add_day_';
        const days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];

        // Aktifkan semua input hari
        days.forEach(day => {
            document.getElementById(prefix + day).disabled = false;
        });

        // Ubah tampilan semua tombol menjadi aktif
        document.querySelectorAll(`#${formId} .day-btn`).forEach(button => {
            button.classList.add('bg-[#3E81AB]', 'text-white');
        });
    }

    function setSelectedDays(daysArray, formType) {
        const formId = formType === 'edit' ? 'editPackageForm' : 'addPackageForm';
        const prefix = formType === 'edit' ? 'edit_day_' : 'add_day_';
        const allDays = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];

        // Reset semua tombol dan input terlebih dahulu
        allDays.forEach(day => {
            document.getElementById(prefix + day).disabled = true;
        });

        document.querySelectorAll(`#${formId} .day-btn`).forEach(button => {
            button.classList.remove('bg-[#3E81AB]', 'text-white');
        });

        // Aktifkan hari-hari yang dipilih
        daysArray.forEach(day => {
            document.getElementById(prefix + day).disabled = false;

            const button = document.querySelector(`#${formId} .day-btn[data-day="${day}"]`);
            if (button) {
                button.classList.add('bg-[#3E81AB]', 'text-white');
            }
        });
    }

    // Inisialisasi tombol pilih hari saat dokumen siap
    document.addEventListener('DOMContentLoaded', function() {
        initializeDayButtons('add');
        initializeDayButtons('edit');
    });
</script>
