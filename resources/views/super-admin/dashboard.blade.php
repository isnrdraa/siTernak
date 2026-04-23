<x-super-admin-layout>
    <x-slot name="header">Dashboard Platform</x-slot>

    <div class="space-y-6">
        {{-- Stats --}}
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
            <x-stats-card title="Total Tenant" :value="$stats['total_tenants']" color="purple">
                <x-slot name="icon"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg></x-slot>
                Aktif: {{ $stats['active_tenants'] }} · Suspend: {{ $stats['suspended_tenants'] }}
            </x-stats-card>

            <x-stats-card title="Total User" :value="number_format($stats['total_users'])" color="blue">
                <x-slot name="icon"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/></svg></x-slot>
            </x-stats-card>

            <x-stats-card title="Produksi Hari Ini" :value="number_format($stats['today_production']) . ' catatan'" color="emerald">
                <x-slot name="icon"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg></x-slot>
                {{ number_format($stats['total_ternak']) }} ekor total ternak
            </x-stats-card>

            <x-stats-card title="Kematian Hari Ini" :value="$stats['today_mortality'] . ' ekor'" :color="$stats['today_mortality'] > 0 ? 'red' : 'gray'">
                <x-slot name="icon"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg></x-slot>
            </x-stats-card>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            {{-- Top Tenants --}}
            <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                <div class="px-5 py-4 border-b border-gray-200">
                    <h3 class="text-sm font-semibold text-gray-900">Tenant Paling Produktif (7 Hari)</h3>
                </div>
                @if($topTenants->isEmpty())
                    <div class="px-5 py-8 text-center text-gray-500 text-sm">Belum ada data.</div>
                @else
                    <div class="divide-y divide-gray-100">
                        @foreach($topTenants as $i => $tenant)
                            <div class="px-5 py-3 flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <span class="w-6 h-6 rounded-full bg-gray-100 text-gray-600 text-xs font-bold flex items-center justify-center">{{ $i + 1 }}</span>
                                    <div>
                                        <a href="{{ route('super-admin.tenants.show', $tenant) }}" class="text-sm font-medium text-gray-900 hover:text-purple-600">{{ $tenant->name }}</a>
                                        <p class="text-xs text-gray-500">{{ $tenant->users_count }} user</p>
                                    </div>
                                </div>
                                <span class="text-sm font-bold text-emerald-600">{{ number_format($tenant->total_records ?? 0) }} catatan</span>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- Recent Tenants --}}
            <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                <div class="px-5 py-4 border-b border-gray-200 flex items-center justify-between">
                    <h3 class="text-sm font-semibold text-gray-900">Tenant Terbaru</h3>
                    <a href="{{ route('super-admin.tenants.index') }}" class="text-xs text-purple-600 hover:text-purple-700">Lihat semua</a>
                </div>
                <div class="divide-y divide-gray-100">
                    @foreach($recentTenants as $tenant)
                        <div class="px-5 py-3 flex items-center justify-between">
                            <div>
                                <a href="{{ route('super-admin.tenants.show', $tenant) }}" class="text-sm font-medium text-gray-900 hover:text-purple-600">{{ $tenant->name }}</a>
                                <p class="text-xs text-gray-500">{{ $tenant->users_count }} user · {{ $tenant->created_at->translatedFormat('d M Y') }}</p>
                            </div>
                            <x-status-badge :status="$tenant->status->value" />
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-super-admin-layout>
