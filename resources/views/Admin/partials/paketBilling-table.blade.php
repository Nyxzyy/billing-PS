<table class="min-w-full divide-y divide-gray-200">
    <thead class="bg-[#3E81AB]">
        <tr>
            <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">No</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Nama Paket Billing
            </th>
            <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Durasi</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Harga (Rp)</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Hari Aktif</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Aksi</th>
        </tr>
    </thead>
    <tbody class="bg-white divide-y divide-gray-200">
        @forelse($packages as $index => $package)
            <tr>
                <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $packages->firstItem() + $index }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $package->package_name }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm">
                    @if ($package->duration_hours > 0)
                        {{ $package->duration_hours }} Jam
                    @endif
                    @if ($package->duration_minutes > 0)
                        {{ $package->duration_minutes }} Menit
                    @endif
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm">{{ number_format($package->total_price, 0, ',', '.') }}
                </td>
                <td>
                    @if (is_array($package->active_days))
                        {{ implode(', ', $package->active_days) }}
                    @else
                        {{ json_decode($package->active_days) ? implode(', ', json_decode($package->active_days)) : '' }}
                    @endif
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm space-x-2">
                    <button
                        onclick="openModal('modalEditPaket', {{ $package->id }}, '{{ $package->package_name }}', {{ $package->duration_hours }}, {{ $package->duration_minutes }}, {{ $package->total_price }}, {{ json_encode($package->active_days) }})"
                        class="text-[#3E81AB] hover:text-[#2C5F7C] font-medium flex items-center gap-1 cursor-pointer">
                        Edit
                    </button>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="8" class="px-6 py-4 text-center text-sm text-gray-500">
                    Tidak ada data Paket Billing
                </td>
            </tr>
        @endforelse
    </tbody>
</table>
