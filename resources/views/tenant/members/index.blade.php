<x-app-layout>
    <x-slot name="header">Anggota Tenant</x-slot>

    <div class="space-y-4">
        {{-- Header --}}
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500">Kelola anggota usaha <strong>{{ $tenant->name }}</strong></p>
            </div>
            @can('manage-members')
                <a href="{{ route('members.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-600 text-white text-sm font-medium rounded-lg hover:bg-emerald-700 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                    Tambah Anggota
                </a>
            @endcan
        </div>

        {{-- Members Table --}}
        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                            <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                            <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                            <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Bergabung</th>
                            @can('manage-members')
                                <th class="px-5 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            @endcan
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($members as $member)
                            <tr class="hover:bg-gray-50">
                                <td class="px-5 py-3">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-emerald-100 flex items-center justify-center">
                                            <span class="text-sm font-medium text-emerald-700">{{ substr($member->name, 0, 1) }}</span>
                                        </div>
                                        <span class="text-sm font-medium text-gray-900">{{ $member->name }}</span>
                                    </div>
                                </td>
                                <td class="px-5 py-3 text-sm text-gray-500">{{ $member->email }}</td>
                                <td class="px-5 py-3">
                                    @php $role = $member->roles->first()?->name ?? '-'; @endphp
                                    <x-status-badge :status="$role" />
                                </td>
                                <td class="px-5 py-3 text-sm text-gray-500">{{ $member->pivot->joined_at ? \Carbon\Carbon::parse($member->pivot->joined_at)->format('d M Y') : '-' }}</td>
                                @can('manage-members')
                                    <td class="px-5 py-3 text-right">
                                        <div class="flex items-center justify-end gap-2">
                                            <a href="{{ route('members.edit', $member) }}" class="text-sm text-blue-600 hover:text-blue-700 font-medium">Edit</a>
                                            @if($member->id !== auth()->id())
                                                <form method="POST" action="{{ route('members.destroy', $member) }}" onsubmit="return confirm('Yakin hapus anggota ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-sm text-red-600 hover:text-red-700 font-medium">Hapus</button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                @endcan
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
