<table class="min-w-full divide-y divide-gray-200">
    <thead class="bg-[#3E81AB]">
        <tr>
            <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                No</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                Nama Perangkat</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                Jenis Paket</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                Waktu Paket</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                Tanggal</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                Waktu Mulai</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                Waktu Berhenti</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                Harga (Rp)</th>
        </tr>
    </thead>
    <tbody class="bg-white divide-y divide-gray-200">
        @foreach ($transactions as $index => $transaction)
            <tr>
                <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $loop->iteration }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $transaction->device->name }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $transaction->package_name }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $transaction->package_time }}
                    Menit</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm">
                    {{ $transaction->created_at->format('d-m-Y') }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm">
                    {{ $transaction->start_time->format('H:i:s') }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm">
                    {{ $transaction->end_time ? $transaction->end_time->format('H:i:s') : 'Berjalan' }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm">
                    {{ number_format($transaction->total_price, 0, ',', '.') }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
