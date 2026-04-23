<x-app-layout>
    <x-slot name="header">Laporan Produksi</x-slot>

    <div class="space-y-6">
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

        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
            <x-stats-card title="Total Catatan" :value="number_format($summary['total_records'])" color="emerald">
                <x-slot name="icon"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg></x-slot>
            </x-stats-card>
            <x-stats-card title="Total Produksi" :value="number_format($summary['total_quantity'], 0)" color="blue">
                <x-slot name="icon"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg></x-slot>
            </x-stats-card>
            <x-stats-card title="Rata-rata/Hari" :value="number_format($summary['avg_daily_records'])" color="amber">
                <x-slot name="icon"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg></x-slot>
                catatan produksi
            </x-stats-card>
            <x-stats-card title="Total Rusak" :value="number_format($summary['total_damaged'], 0)" color="red">
                <x-slot name="icon"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg></x-slot>
                {{ $summary['total_quantity'] > 0 ? round(($summary['total_damaged'] / $summary['total_quantity']) * 100, 1) : 0 }}% dari total
            </x-stats-card>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <h3 class="text-sm font-semibold text-gray-900 mb-4">Tren Produksi Harian (Catatan per Hari)</h3>
            <div class="h-72">
                <canvas id="prodChart"></canvas>
            </div>
        </div>

        @if($byProduct->isNotEmpty())
            <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                <div class="px-5 py-4 border-b border-gray-200">
                    <h3 class="text-sm font-semibold text-gray-900">Produksi per Produk</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase">Produk</th>
                                <th class="px-5 py-3 text-right text-xs font-medium text-gray-500 uppercase">Total</th>
                                <th class="px-5 py-3 text-right text-xs font-medium text-gray-500 uppercase">Rusak</th>
                                <th class="px-5 py-3 text-right text-xs font-medium text-gray-500 uppercase">Baik</th>
                                <th class="px-5 py-3 text-right text-xs font-medium text-gray-500 uppercase">Catatan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($byProduct as $item)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-5 py-3 text-sm font-medium text-gray-900">{{ $item->product->name }} <span class="text-gray-400">({{ $item->product->unit }})</span></td>
                                    <td class="px-5 py-3 text-sm text-gray-900 text-right font-semibold">{{ number_format($item->total_qty, 0) }}</td>
                                    <td class="px-5 py-3 text-sm text-red-600 text-right">{{ number_format($item->total_damaged, 0) }}</td>
                                    <td class="px-5 py-3 text-sm text-emerald-600 text-right font-medium">{{ number_format($item->total_qty - $item->total_damaged, 0) }}</td>
                                    <td class="px-5 py-3 text-sm text-gray-500 text-right">{{ $item->records }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

        @if($perCage->isNotEmpty())
            <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                <div class="px-5 py-4 border-b border-gray-200">
                    <h3 class="text-sm font-semibold text-gray-900">Produksi per Kandang</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kandang</th>
                                <th class="px-5 py-3 text-right text-xs font-medium text-gray-500 uppercase">Total Produksi</th>
                                <th class="px-5 py-3 text-right text-xs font-medium text-gray-500 uppercase">Rusak</th>
                                <th class="px-5 py-3 text-right text-xs font-medium text-gray-500 uppercase">Hari Aktif</th>
                                <th class="px-5 py-3 text-right text-xs font-medium text-gray-500 uppercase">Rata-rata/Hari</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($perCage as $item)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-5 py-3 text-sm font-medium text-gray-900">{{ $item->cage->name }}</td>
                                    <td class="px-5 py-3 text-sm text-gray-900 text-right font-semibold">{{ number_format($item->total_qty, 0) }}</td>
                                    <td class="px-5 py-3 text-sm text-red-600 text-right">{{ number_format($item->total_damaged, 0) }}</td>
                                    <td class="px-5 py-3 text-sm text-gray-700 text-right">{{ $item->days }}</td>
                                    <td class="px-5 py-3 text-sm text-gray-700 text-right">{{ $item->days > 0 ? number_format($item->total_qty / $item->days, 0) : 0 }}</td>
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
        new Chart(document.getElementById('prodChart'), {
            type: 'line',
            data: {
                labels: @json($chartData['labels']),
                datasets: [{
                    label: 'Catatan Produksi',
                    data: @json($chartData['records']),
                    borderColor: 'rgb(16, 185, 129)',
                    backgroundColor: 'rgba(16, 185, 129, 0.1)',
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
