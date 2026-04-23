<x-super-admin-layout>
    <x-slot name="header">Detail Tenant: {{ $tenant->name }}</x-slot>

    <div class="space-y-6">
        {{-- Header Actions --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <p class="text-sm text-gray-500">Slug: <span class="font-mono text-gray-700">{{ $tenant->slug }}</span></p>
                <p class="text-sm text-gray-500 mt-1">Dibuat: {{ $tenant->created_at->translatedFormat('d M Y H:i') }}</p>
            </div>
            <div class="flex items-center gap-3">
                <x-status-badge :status="$tenant->status->value" class="text-sm" />
                @if($tenant->status->value === 'active')
                    <form method="POST" action="{{ route('super-admin.tenants.suspend', $tenant) }}" onsubmit="return confirm('Yakin suspend tenant ini?')">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="inline-flex items-center px-3 py-1.5 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700 transition-colors">Suspend</button>
                    </form>
                @else
                    <form method="POST" action="{{ route('super-admin.tenants.activate', $tenant) }}">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="inline-flex items-center px-3 py-1.5 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 transition-colors">Aktifkan</button>
                    </form>
                @endif
            </div>
        </div>

        {{-- Stats --}}
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
            <x-stats-card title="Total User" :value="$tenant->users_count" color="blue">
                <x-slot name="icon"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/></svg></x-slot>
            </x-stats-card>
            <x-stats-card title="Kandang" :value="$tenant->cages_count" color="emerald">
                <x-slot name="icon"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21V10l9-7 9 7v11H3zM9 21v-6h6v6M3 10l9-4 9 4"/></svg></x-slot>
            </x-stats-card>
            <x-stats-card title="Ternak Aktif" :value="number_format($stats['total_ternak']) . ' ekor'" color="amber">
                <x-slot name="icon"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg></x-slot>
            </x-stats-card>
            <x-stats-card title="Total Produksi" :value="number_format($stats['total_production']) . ' catatan'" color="purple">
                <x-slot name="icon"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg></x-slot>
                @if($stats['last_activity'])
                    Aktivitas terakhir: {{ \Carbon\Carbon::parse($stats['last_activity'])->translatedFormat('d M Y') }}
                @endif
            </x-stats-card>
        </div>

        {{-- Members --}}
        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
            <div class="px-5 py-4 border-b border-gray-200">
                <h3 class="text-sm font-semibold text-gray-900">Daftar Anggota</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                            <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                            <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase">Bergabung</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($members as $member)
                            <tr class="hover:bg-gray-50">
                                <td class="px-5 py-3 text-sm font-medium text-gray-900">{{ $member->name }}</td>
                                <td class="px-5 py-3 text-sm text-gray-500">{{ $member->email }}</td>
                                <td class="px-5 py-3 text-sm text-gray-500">
                                    {{ $member->pivot->joined_at ? \Carbon\Carbon::parse($member->pivot->joined_at)->translatedFormat('d M Y') : '-' }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div>
            <a href="{{ route('super-admin.tenants.index') }}" class="text-sm text-gray-600 hover:text-gray-900">&larr; Kembali ke daftar tenant</a>
        </div>
    </div>
</x-super-admin-layout>
