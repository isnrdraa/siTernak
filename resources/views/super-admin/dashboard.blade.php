<x-super-admin-layout>
    <x-slot name="header">Dashboard Platform</x-slot>

    <div class="space-y-6">
        {{-- KPI Cards --}}
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
            <x-stats-card title="Total Tenant" :value="$stats['total_tenants']" color="purple">
                <x-slot name="icon"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg></x-slot>
                Aktif: {{ $stats['active_tenants'] }} · Suspend: {{ $stats['suspended_tenants'] }}
            </x-stats-card>

            <x-stats-card title="Total User" :value="number_format($stats['total_users'])" color="blue">
                <x-slot name="icon"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/></svg></x-slot>
            </x-stats-card>

            <x-stats-card title="Tenant Baru (Bulan Ini)" :value="$stats['new_tenants_this_month']" color="emerald">
                <x-slot name="icon"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg></x-slot>
            </x-stats-card>

            <x-stats-card title="User Baru (Bulan Ini)" :value="$stats['new_users_this_month']" color="amber">
                <x-slot name="icon"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg></x-slot>
            </x-stats-card>
        </div>

        {{-- Charts --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Tenant Growth Chart --}}
            <div class="lg:col-span-2 bg-white rounded-xl border border-gray-200 p-5">
                <h3 class="text-sm font-semibold text-gray-900 mb-4">Pertumbuhan Registrasi (30 Hari)</h3>
                <canvas id="growthChart" height="120"></canvas>
            </div>

            {{-- Tenant Status Breakdown --}}
            <div class="bg-white rounded-xl border border-gray-200 p-5">
                <h3 class="text-sm font-semibold text-gray-900 mb-4">Status Tenant</h3>
                <canvas id="statusChart" height="180"></canvas>
                <div class="mt-4 space-y-2">
                    <div class="flex items-center justify-between text-sm">
                        <span class="flex items-center gap-2"><span class="w-3 h-3 rounded-full bg-emerald-500"></span> Aktif</span>
                        <span class="font-semibold text-gray-900">{{ $tenantsByStatus['active'] }}</span>
                    </div>
                    <div class="flex items-center justify-between text-sm">
                        <span class="flex items-center gap-2"><span class="w-3 h-3 rounded-full bg-red-500"></span> Suspended</span>
                        <span class="font-semibold text-gray-900">{{ $tenantsByStatus['suspended'] }}</span>
                    </div>
                    <div class="flex items-center justify-between text-sm">
                        <span class="flex items-center gap-2"><span class="w-3 h-3 rounded-full bg-gray-400"></span> Tidak Aktif</span>
                        <span class="font-semibold text-gray-900">{{ $tenantsByStatus['inactive'] }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            {{-- Top Tenants by Users --}}
            <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                <div class="px-5 py-4 border-b border-gray-200">
                    <h3 class="text-sm font-semibold text-gray-900">Tenant dengan User Terbanyak</h3>
                </div>
                @if($topTenantsByUsers->isEmpty())
                    <div class="px-5 py-8 text-center text-gray-500 text-sm">Belum ada data.</div>
                @else
                    <div class="divide-y divide-gray-100">
                        @foreach($topTenantsByUsers as $i => $tenant)
                            <div class="px-5 py-3 flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <span class="w-6 h-6 rounded-full bg-purple-100 text-purple-600 text-xs font-bold flex items-center justify-center">{{ $i + 1 }}</span>
                                    <div>
                                        <a href="{{ route('super-admin.tenants.show', $tenant) }}" class="text-sm font-medium text-gray-900 hover:text-purple-600">{{ $tenant->name }}</a>
                                        <p class="text-xs text-gray-500">{{ $tenant->slug }}</p>
                                    </div>
                                </div>
                                <span class="text-sm font-bold text-purple-600">{{ $tenant->users_count }} user</span>
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
                @if($recentTenants->isEmpty())
                    <div class="px-5 py-8 text-center text-gray-500 text-sm">Belum ada tenant.</div>
                @else
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
                @endif
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4/dist/chart.umd.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const days = [];
            const now = new Date();
            for (let i = 29; i >= 0; i--) {
                const d = new Date(now);
                d.setDate(d.getDate() - i);
                days.push(d.toISOString().split('T')[0]);
            }

            const tenantData = @json($tenantGrowth);
            const userData = @json($userGrowth);

            new Chart(document.getElementById('growthChart'), {
                type: 'bar',
                data: {
                    labels: days.map(d => {
                        const dt = new Date(d);
                        return dt.getDate() + '/' + (dt.getMonth() + 1);
                    }),
                    datasets: [
                        {
                            label: 'Tenant Baru',
                            data: days.map(d => tenantData[d] || 0),
                            backgroundColor: 'rgba(147, 51, 234, 0.7)',
                            borderRadius: 4,
                        },
                        {
                            label: 'User Baru',
                            data: days.map(d => userData[d] || 0),
                            backgroundColor: 'rgba(59, 130, 246, 0.7)',
                            borderRadius: 4,
                        }
                    ]
                },
                options: {
                    responsive: true,
                    plugins: { legend: { position: 'top', labels: { usePointStyle: true, pointStyle: 'circle', font: { size: 12 } } } },
                    scales: {
                        y: { beginAtZero: true, ticks: { stepSize: 1, font: { size: 11 } }, grid: { color: '#f3f4f6' } },
                        x: { ticks: { font: { size: 10 }, maxRotation: 45 }, grid: { display: false } }
                    }
                }
            });

            new Chart(document.getElementById('statusChart'), {
                type: 'doughnut',
                data: {
                    labels: ['Aktif', 'Suspended', 'Tidak Aktif'],
                    datasets: [{
                        data: [{{ $tenantsByStatus['active'] }}, {{ $tenantsByStatus['suspended'] }}, {{ $tenantsByStatus['inactive'] }}],
                        backgroundColor: ['#10b981', '#ef4444', '#9ca3af'],
                        borderWidth: 0,
                    }]
                },
                options: {
                    responsive: true,
                    cutout: '65%',
                    plugins: { legend: { display: false } }
                }
            });
        });
    </script>
    @endpush
</x-super-admin-layout>
