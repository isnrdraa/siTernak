<x-app-layout>
    <x-slot name="header">Laporan Konsumsi Pakan</x-slot>

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
                <div>
                    <x-input-label for="cage_id" value="Kandang" />
                    <select id="cage_id" name="cage_id" class="block mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                        <option value="">Semua</option>
                        @foreach($cages as $cage)
                            <option value="{{ $cage->id }}" @selected($cageId == $cage->id)>{{ $cage->name }}</option>
                        @endforeach
                    </select>
                </div>
                <x-primary-button class="h-10">Tampilkan</x-primary-button>
            </div>
        </form>

        {{-- Summary Cards --}}
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
            <x-stats-card title="Total Pakan" :value="number_format($summary['total_kg'], 1) . ' kg'" color="blue">
                <x-slot name="icon"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg></x-slot>
            </x-stats-card>
            <x-stats-card title="Rata-rata Harian" :value="number_format($summary['avg_daily_kg'], 1) . ' kg'" color="amber">
                <x-slot name="icon"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg></x-slot>
            </x-stats-card>
            <x-stats-card title="Pakan per Ekor" :value="$summary['avg_per_ekor'] . ' g/hari'" color="emerald">
                <x-slot name="icon"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"/></svg></x-slot>
            </x-stats-card>
            <x-stats-card title="Total Catatan" :value="$summary['total_entries']" color="gray">
                <x-slot name="icon"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg></x-slot>
            </x-stats-card>
        </div>

        {{-- Chart --}}
        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <h3 class="text-sm font-semibold text-gray-900 mb-4">Tren Konsumsi Pakan Harian</h3>
            <div class="h-72">
                <canvas id="feedChart"></canvas>
            </div>
        </div>

        {{-- By Feed Type --}}
        @if($byType->isNotEmpty())
            <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                <div class="px-5 py-4 border-b border-gray-200">
                    <h3 class="text-sm font-semibold text-gray-900">Konsumsi per Jenis Pakan</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jenis Pakan</th>
                                <th class="px-5 py-3 text-right text-xs font-medium text-gray-500 uppercase">Total (kg)</th>
                                <th class="px-5 py-3 text-right text-xs font-medium text-gray-500 uppercase">Jumlah Catatan</th>
                                <th class="px-5 py-3 text-right text-xs font-medium text-gray-500 uppercase">% dari Total</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($byType as $item)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-5 py-3 text-sm font-medium text-gray-900">{{ $item->feed_type }}</td>
                                    <td class="px-5 py-3 text-sm text-gray-900 text-right font-semibold">{{ number_format($item->total_kg, 1) }}</td>
                                    <td class="px-5 py-3 text-sm text-gray-700 text-right">{{ $item->entries }}</td>
                                    <td class="px-5 py-3 text-sm text-gray-700 text-right">{{ $summary['total_kg'] > 0 ? round(($item->total_kg / $summary['total_kg']) * 100, 1) : 0 }}%</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4/dist/chart.umd.min.js"></script>
    <script>
        new Chart(document.getElementById('feedChart'), {
            type: 'line',
            data: {
                labels: @json($chartData['labels']),
                datasets: [{
                    label: 'Pakan (kg)',
                    data: @json($chartData['feed']),
                    borderColor: 'rgb(59, 130, 246)',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    fill: true,
                    tension: 0.3,
                    pointRadius: 3,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { position: 'bottom', labels: { boxWidth: 12, padding: 16, font: { size: 11 } } } },
                scales: {
                    x: { grid: { display: false }, ticks: { font: { size: 10 }, maxRotation: 45 } },
                    y: { beginAtZero: true, ticks: { font: { size: 10 } } },
                },
            },
        });
    </script>
    @endpush
</x-app-layout>
