<table class="min-w-full divide-y divide-gray-200">
    <thead class="bg-[#3E81AB]">
        <tr>
            <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                No</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                Nama Pengguna</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                Email</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                No. Telp</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                Alamat</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                Aksi</th>
        </tr>
    </thead>
    <tbody class="bg-white divide-y divide-gray-200">
        @forelse($users as $index => $user)
            <tr>
                <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $users->firstItem() + $index }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $user->name }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $user->email }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $user->phone_number }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $user->address }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm flex gap-2">
                    <button
                        onclick="editUser('{{ $user->id }}', '{{ $user->name }}', '{{ $user->email }}', '{{ $user->phone_number }}', '{{ $user->address }}')"
                        class="text-[#3E81AB] hover:text-[#2C5F7C] font-medium flex items-center gap-1 cursor-pointer">
                        Edit
                    </button>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7" class="px-6 py-4 text-center text-gray-500">Tidak ada pengguna
                    yang ditemukan</td>
            </tr>
        @endforelse
    </tbody>
</table>
