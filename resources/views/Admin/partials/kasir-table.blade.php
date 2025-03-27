<table class="min-w-full divide-y divide-gray-200">
    <thead class="bg-[#3E81AB]">
        <tr>
            <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                No</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                Nama Kasir</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                Total Transaksi</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                Total Pendapatan (Rp)</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                Jam Kerja</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                Tanggal Kerja</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                Shift Mulai Kerja</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                Shift Selesai Kerja</th>
        </tr>
    </thead>
    <tbody class="bg-white divide-y divide-gray-200">
        @foreach ($reports as $index => $report)
            <tr>
                <td class="px-6 py-4 whitespace-nowrap text-sm">
                    {{ $reports->firstItem() + $index }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $report->cashier->name }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm">
                    {{ number_format($report->total_transactions) }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm">
                    {{ number_format($report->total_revenue, 0, ',', '.') }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm">
                    {{ number_format($report->total_work_hours, 1) }} Jam</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm">
                    {{ \Carbon\Carbon::parse($report->work_date)->format('d/m/Y') }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm">
                    {{ \Carbon\Carbon::parse($report->shift_start)->format('d/m/Y H:i:s') }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm">
                    {{ \Carbon\Carbon::parse($report->shift_end)->format('d/m/Y H:i:s') }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
