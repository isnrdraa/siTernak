<x-app-layout>
    <x-slot name="header">Laporan Kesehatan</x-slot>

    <div class="space-y-6">
        {{-- Filter --}}
        <form method="GET" class="bg-white rounded-xl border border-gray-200 p-4">
            <div class="flex flex-wrap items-end gap-3">
                <div>
                    <x-input-label for="start_date" value="Dari Tanggal" />
                    <x-text-input id="start_date" class="block mt-1" type="date" name="start_date" :value="$startDate" />
                </div>
                <div>
                    <x-input-label for="end_date" value="Sampai Tanggal" />
                    <x-text-input id="end_date" class="block mt-1" type="date" name="end_date" :value="$endDate" />
                </div>
                <x-primary-button class="h-10">Tampilkan</x-primary-button>
            </div>
        </form>

        {{-- Summary Cards --}}
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
            <x-stats-card title="Total Kejadian" :value="$summary['total_events']" color="blue">
                <x-slot name="icon"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg></x-slot>
            </x-stats-card>
            <x-stats-card title="Penyakit" :value="$summary['diseases']" :color="$summary['diseases'] > 0 ? 'red' : 'gray'">
                <x-slot name="icon"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg></x-slot>
            </x-stats-card>
            <x-stats-card title="Vaksinasi" :value="$summary['vaccinations']" color="emerald">
                <x-slot name="icon"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg></x-slot>
            </x-stats-card>
            <x-stats-card title="Perawatan" :value="$summary['treatments'] + $summary['checkups']" color="amber">
                <x-slot name="icon"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg></x-slot>
                Perawatan {{ $summary['treatments'] }} + Pemeriksaan {{ $summary['checkups'] }}
            </x-stats-card>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            {{-- Pie Chart --}}
            <div class="bg-white rounded-xl border border-gray-200 p-5">
                <h3 class="text-sm font-semibold text-gray-900 mb-4">Distribusi Jenis Kejadian</h3>
                <div class="h-64 flex items-center justify-center">
                    @if($byType->isNotEmpty())
                        <canvas id="healthPieChart"></canvas>
                    @else
                        <p class="text-sm text-gray-400">Tidak ada data.</p>
                    @endif
                </div>
            </div>

            {{-- Type Summary --}}
            <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                <div class="px-5 py-4 border-b border-gray-200">
                    <h3 class="text-sm font-semibold text-gray-900">Ringkasan per Jenis</h3>
                </div>
                @if($byType->isEmpty())
                    <div class="px-5 py-8 text-center text-gray-500">
                        <p class="text-sm">Tidak ada data.</p>
                    </div>
                @else
                    <div class="divide-y divide-gray-100">
                        @foreach($byType as $item)
                            <div class="px-5 py-3 flex items-center justify-between">
                                <x-status-badge :status="$item->type" />
                                <span class="text-sm font-bold text-gray-900">{{ $item->total }}</span>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        {{-- Recent Health Logs --}}
        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
            <div class="px-5 py-4 border-b border-gray-200">
                <h3 class="text-sm font-semibold text-gray-900">Catatan Kesehatan Terbaru</h3>
            </div>
            @if($recentLogs->isEmpty())
                <div class="px-5 py-8 text-center text-gray-500">
                    <p class="text-sm">Tidak ada data kesehatan pada periode ini.</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                                <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jenis</th>
                                <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kandang</th>
                                <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase">Keterangan</th>
                                <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tindakan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($recentLogs as $log)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-5 py-3 text-sm text-gray-900">{{ $log->date->translatedFormat('d M Y') }}</td>
                                    <td class="px-5 py-3"><x-status-badge :status="$log->type" /></td>
                                    <td class="px-5 py-3 text-sm text-gray-700">{{ $log->cage->name }}</td>
                                    <td class="px-5 py-3 text-sm text-gray-500 max-w-xs truncate">{{ $log->description ?? '-' }}</td>
                                    <td class="px-5 py-3 text-sm text-gray-500 max-w-xs truncate">{{ $log->treatment ?? '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4/dist/chart.umd.min.js"></script>
    <script>
        @if($byType->isNotEmpty())
        const pieColors = ['rgb(59, 130, 246)', 'rgb(245, 158, 11)', 'rgb(16, 185, 129)', 'rgb(239, 68, 68)', 'rgb(139, 92, 246)'];
        new Chart(document.getElementById('healthPieChart'), {
            type: 'doughnut',
            data: {
                labels: @json($chartData['labels']),
                datasets: [{
                    data: @json($chartData['data']),
                    backgroundColor: pieColors.slice(0, @json($chartData['data']->count())),
                    borderWidth: 0,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'bottom', labels: { boxWidth: 12, padding: 16, font: { size: 11 } } },
                },
            },
        });
        @endif
    </script>
    @endpush
</x-app-layout>
