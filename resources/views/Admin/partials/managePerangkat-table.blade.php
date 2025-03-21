<table class="min-w-full divide-y divide-gray-200">
    <thead class="bg-[#3E81AB]">
        <tr>
            <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                No</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                Nama Device</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                Lokasi Device</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                IP Address Device</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                Aksi</th>
        </tr>
    </thead>
    <tbody class="bg-white divide-y divide-gray-200">
        @forelse($devices as $index => $device)
            <tr>
                <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $devices->firstItem() + $index }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $device->name }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $device->location }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $device->ip_address }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm flex gap-2">
                    <button onclick="openDeviceEditModal({{ $device }})"
                        class="text-[#3E81AB] hover:text-[#2C5F7C] cursor-pointer">
                        Edit
                    </button>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="px-6 py-4 text-center text-gray-500">Tidak ada perangkat
                    yang ditemukan</td>
            </tr>
        @endforelse
    </tbody>
</table>
