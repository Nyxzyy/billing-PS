<table class="min-w-full divide-y divide-gray-200">
    <thead class="bg-[#3E81AB]">
        <tr>
            <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                Waktu</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                Tipe</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                Aktor/Sumber</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                Activity</th>
        </tr>
    </thead>
    <tbody class="bg-white divide-y divide-gray-200 text-left">
        @forelse($logs as $log)
            <tr>
                <td class="px-6 py-4 whitespace-nowrap text-sm">
                    {{ \Carbon\Carbon::parse($log->timestamp)->format('d/m/Y H:i:s') }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm">
                    @if ($log->user_id && !$log->device_id && !$log->transaction_id)
                        User
                    @elseif($log->device_id && !$log->transaction_id)
                        Device
                    @elseif($log->transaction_id)
                        Transaction
                    @else
                        System
                    @endif
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm">
                    @if ($log->user_id && !$log->device_id && !$log->transaction_id)
                        {{ $log->user->name ?? 'N/A' }}
                    @elseif($log->device_id && !$log->transaction_id)
                        {{ $log->device->name ?? 'N/A' }}
                    @elseif($log->transaction_id)
                        {{ $log->transaction->user->name ?? 'N/A' }} -
                        {{ $log->transaction->device->name ?? 'N/A' }}
                    @else
                        System
                    @endif
                </td>
                <td class="px-6 py-4 text-sm whitespace-nowrap">
                    {{ $log->activity }}
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                    Tidak ada aktivitas yang ditemukan
                </td>
            </tr>
        @endforelse
    </tbody>
</table>
