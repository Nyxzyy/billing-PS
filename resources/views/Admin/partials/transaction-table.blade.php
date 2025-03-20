<div class="overflow-x-auto">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-[#3E81AB]">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">No</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Nama Kasir</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Nama Device</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Jenis Paket</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Waktu Paket</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Waktu Mulai</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Waktu Berhenti
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Harga (Rp)</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @forelse($transactions as $index => $transaction)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $transactions->firstItem() + $index }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $transaction->user->name ?? '-' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $transaction->device->name ?? '-' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $transaction->package_name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $transaction->package_time }} Menit</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                        {{ $transaction->start_time ? \Carbon\Carbon::parse($transaction->start_time)->format('d/m/Y H:i:s') : '-' }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                        {{ $transaction->end_time ? \Carbon\Carbon::parse($transaction->end_time)->format('d/m/Y H:i:s') : '-' }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                        {{ number_format($transaction->total_price, 0, ',', '.') }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="px-6 py-4 text-center text-sm text-gray-500">
                        Tidak ada data transaksi
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Pagination section -->
<div class="flex items-center justify-between mt-8 text-sm text-gray-600 p-6">
    <div class="text-sm text-gray-700">
        Menampilkan
        <span class="font-medium">{{ ($transactions->currentPage() - 1) * $transactions->perPage() + 1 }}</span>
        sampai
        <span
            class="font-medium">{{ min($transactions->currentPage() * $transactions->perPage(), $transactions->total()) }}</span>
        dari
        <span class="font-medium">{{ $transactions->total() }}</span>
        hasil
    </div>
    <div class="flex space-x-2">
        {{ $transactions->appends(request()->query())->links() }}
    </div>
</div>
