<table id="kendalaTable" class="min-w-full divide-y divide-gray-200">
    <thead class="bg-[#3E81AB]">
        <tr>
            <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                No</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                Nama Kasir</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                Nama Device</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                Kendala</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                Jam</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                Tanggal</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                Status</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                Waktu Selesai</th>
        </tr>
    </thead>
    <tbody class="bg-white divide-y divide-gray-200">
        @forelse($kendalaReports as $index => $report)
            <tr>
                <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $index + 1 }}</td>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $report->cashier->name ?? '-' }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $report->device->name ?? '-' }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $report->issue }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $report->time }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm">
                    {{ \Carbon\Carbon::parse($report->date)->format('d/m/Y') }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm">
                    <span
                        class="px-2 py-1 rounded-full text-xs {{ $report->status == 'Pending'
                            ? 'bg-yellow-100 text-yellow-800'
                            : ($report->status == 'Proses'
                                ? 'bg-blue-100 text-blue-800'
                                : 'bg-green-100 text-green-800') }}">
                        {{ $report->status }}
                    </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm">
                    @if ($report->status == 'Selesai')
                        {{ \Carbon\Carbon::parse($report->updated_at)->format('d/m/Y H:i:s') }}
                    @else
                        -
                    @endif
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7" class="px-6 py-4 text-center text-gray-500">Tidak ada data
                    kendala yang ditemukan</td>
            </tr>
        @endforelse
    </tbody>
</table>
