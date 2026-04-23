<x-app-layout>
    <x-slot name="header">Laporan Kematian</x-slot>

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
            <x-stats-card title="Total Kematian" :value="$summary['total_mortality'] . ' ekor'" color="red">
                <x-slot name="icon"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg></x-slot>
            </x-stats-card>
            <x-stats-card title="Rata-rata Harian" :value="$summary['avg_daily'] . ' ekor'" color="amber">
                <x-slot name="icon"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg></x-slot>
            </x-stats-card>
            <x-stats-card title="Tingkat Kematian" :value="$summary['mortality_rate'] . '%'" :color="$summary['mortality_rate'] > 1 ? 'red' : 'gray'">
                <x-slot name="icon"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"/></svg></x-slot>
                Dari total populasi aktif
            </x-stats-card>
            <x-stats-card title="Hari Puncak" :value="$summary['peak_day'] ? $summary['peak_day']->total . ' ekor' : '-'" color="gray">
                <x-slot name="icon"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg></x-slot>
                @if($summary['peak_day'])
                    {{ \Carbon\Carbon::parse($summary['peak_day']->d)->translatedFormat('d M Y') }}
                @endif
            </x-stats-card>
        </div>

        {{-- Chart --}}
        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <h3 class="text-sm font-semibold text-gray-900 mb-4">Tren Kematian Harian</h3>
            <div class="h-72">
                <canvas id="mortalityChart"></canvas>
            </div>
        </div>

        {{-- By Cause --}}
        @if($byCause->isNotEmpty())
            <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                <div class="px-5 py-4 border-b border-gray-200">
                    <h3 class="text-sm font-semibold text-gray-900">Kematian per Penyebab</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase">Penyebab</th>
                                <th class="px-5 py-3 text-right text-xs font-medium text-gray-500 uppercase">Jumlah (ekor)</th>
                                <th class="px-5 py-3 text-right text-xs font-medium text-gray-500 uppercase">% dari Total</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($byCause as $item)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-5 py-3 text-sm font-medium text-gray-900">{{ $item->cause_label }}</td>
                                    <td class="px-5 py-3 text-sm text-red-600 text-right font-semibold">{{ $item->total }}</td>
                                    <td class="px-5 py-3 text-sm text-gray-700 text-right">{{ $summary['total_mortality'] > 0 ? round(($item->total / $summary['total_mortality']) * 100, 1) : 0 }}%</td>
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
        new Chart(document.getElementById('mortalityChart'), {
            type: 'bar',
            data: {
                labels: @json($chartData['labels']),
                datasets: [{
                    label: 'Kematian (ekor)',
                    data: @json($chartData['mortality']),
                    backgroundColor: 'rgb(239, 68, 68)',
                    borderRadius: 4,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { position: 'bottom', labels: { boxWidth: 12, padding: 16, font: { size: 11 } } } },
                scales: {
                    x: { grid: { display: false }, ticks: { font: { size: 10 }, maxRotation: 45 } },
                    y: { beginAtZero: true, ticks: { font: { size: 10 }, stepSize: 1 } },
                },
            },
        });
    </script>
    @endpush
</x-app-layout>
