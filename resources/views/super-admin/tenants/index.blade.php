<x-super-admin-layout>
    <x-slot name="header">Kelola Tenant</x-slot>

    <div class="space-y-4">
        <p class="text-sm text-gray-500">Daftar semua tenant yang terdaftar di platform.</p>

        {{-- Filter --}}
        <form method="GET" class="bg-white rounded-xl border border-gray-200 p-4">
            <div class="flex flex-wrap items-end gap-3">
                <div>
                    <x-input-label for="search" value="Cari Tenant" />
                    <x-text-input id="search" class="block mt-1" type="text" name="search" :value="request('search')" placeholder="Nama tenant..." />
                </div>
                <div>
                    <x-input-label for="status" value="Status" />
                    <select id="status" name="status" class="block mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                        <option value="">Semua</option>
                        <option value="active" @selected(request('status') === 'active')>Aktif</option>
                        <option value="suspended" @selected(request('status') === 'suspended')>Suspended</option>
                        <option value="inactive" @selected(request('status') === 'inactive')>Tidak Aktif</option>
                    </select>
                </div>
                <x-primary-button class="h-10">Filter</x-primary-button>
                @if(request()->hasAny(['search', 'status']))
                    <a href="{{ route('super-admin.tenants.index') }}" class="text-sm text-gray-500 hover:text-gray-700 h-10 flex items-center">Reset</a>
                @endif
            </div>
        </form>

        {{-- Table --}}
        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
            @if($tenants->isEmpty())
                <div class="px-5 py-12 text-center text-gray-500">
                    <p class="text-sm">Tidak ada tenant ditemukan.</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                                <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase">Slug</th>
                                <th class="px-5 py-3 text-center text-xs font-medium text-gray-500 uppercase">User</th>
                                <th class="px-5 py-3 text-center text-xs font-medium text-gray-500 uppercase">Kandang</th>

                                <th class="px-5 py-3 text-center text-xs font-medium text-gray-500 uppercase">Status</th>
                                <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase">Dibuat</th>
                                <th class="px-5 py-3 text-right text-xs font-medium text-gray-500 uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($tenants as $tenant)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-5 py-3">
                                        <a href="{{ route('super-admin.tenants.show', $tenant) }}" class="text-sm font-medium text-gray-900 hover:text-purple-600">{{ $tenant->name }}</a>
                                    </td>
                                    <td class="px-5 py-3 text-sm text-gray-500 font-mono">{{ $tenant->slug }}</td>
                                    <td class="px-5 py-3 text-sm text-gray-700 text-center">{{ $tenant->users_count }}</td>
                                    <td class="px-5 py-3 text-sm text-gray-700 text-center">{{ $tenant->cages_count }}</td>
                                    <td class="px-5 py-3 text-center"><x-status-badge :status="$tenant->status->value" /></td>
                                    <td class="px-5 py-3 text-sm text-gray-500">{{ $tenant->created_at->translatedFormat('d M Y') }}</td>
                                    <td class="px-5 py-3 text-right">
                                        <div class="flex items-center justify-end gap-2">
                                            <a href="{{ route('super-admin.tenants.show', $tenant) }}" class="text-sm text-blue-600 hover:text-blue-700">Detail</a>
                                            @if($tenant->status->value === 'active')
                                                <form method="POST" action="{{ route('super-admin.tenants.suspend', $tenant) }}" onsubmit="return confirm('Yakin suspend tenant ini?')">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="text-sm text-red-600 hover:text-red-700">Suspend</button>
                                                </form>
                                            @else
                                                <form method="POST" action="{{ route('super-admin.tenants.activate', $tenant) }}">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="text-sm text-green-600 hover:text-green-700">Aktifkan</button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="px-5 py-3 border-t border-gray-200">
                    {{ $tenants->links() }}
                </div>
            @endif
        </div>
    </div>
</x-super-admin-layout>
