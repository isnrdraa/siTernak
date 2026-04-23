<x-app-layout>
    <x-slot name="header">Laba / Rugi</x-slot>

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
                <x-primary-button class="h-10">Tampilkan</x-primary-button>
            </div>
        </form>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <x-stats-card title="Total Pemasukan" :value="'Rp ' . number_format($summary['totalSales'])" color="emerald">
                <x-slot name="icon"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg></x-slot>
            </x-stats-card>
            <x-stats-card title="Total Pengeluaran" :value="'Rp ' . number_format($summary['totalExpenses'])" color="red">
                <x-slot name="icon"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"/></svg></x-slot>
            </x-stats-card>
            <x-stats-card title="Laba / Rugi" :value="'Rp ' . number_format(abs($summary['profit']))" :color="$summary['profit'] >= 0 ? 'emerald' : 'red'">
                <x-slot name="icon"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg></x-slot>
                {{ $summary['profit'] >= 0 ? 'Laba' : 'Rugi' }}
            </x-stats-card>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <h3 class="text-sm font-semibold text-gray-900 mb-4">Tren Pemasukan vs Pengeluaran</h3>
            <div class="h-72">
                <canvas id="financeChart"></canvas>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                <div class="px-5 py-4 border-b border-gray-200">
                    <h3 class="text-sm font-semibold text-gray-900">Pemasukan per Produk</h3>
                </div>
                @if($salesByProduct->isEmpty())
                    <div class="px-5 py-8 text-center text-gray-500 text-sm">Tidak ada data.</div>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase">Produk</th>
                                    <th class="px-5 py-3 text-right text-xs font-medium text-gray-500 uppercase">Terjual</th>
                                    <th class="px-5 py-3 text-right text-xs font-medium text-gray-500 uppercase">Total</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach($salesByProduct as $item)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-5 py-3 text-sm font-medium text-gray-900">{{ $item->product->name }}</td>
                                        <td class="px-5 py-3 text-sm text-gray-700 text-right">{{ number_format($item->total_qty, 2) }} {{ $item->product->unit }}</td>
                                        <td class="px-5 py-3 text-sm text-emerald-600 text-right font-semibold">Rp {{ number_format($item->total_amount) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

            <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                <div class="px-5 py-4 border-b border-gray-200">
                    <h3 class="text-sm font-semibold text-gray-900">Pengeluaran per Kategori</h3>
                </div>
                @if($expensesByCategory->isEmpty())
                    <div class="px-5 py-8 text-center text-gray-500 text-sm">Tidak ada data.</div>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kategori</th>
                                    <th class="px-5 py-3 text-right text-xs font-medium text-gray-500 uppercase">Catatan</th>
                                    <th class="px-5 py-3 text-right text-xs font-medium text-gray-500 uppercase">Total</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach($expensesByCategory as $item)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-5 py-3 text-sm font-medium text-gray-900">{{ $item->category->label() }}</td>
                                        <td class="px-5 py-3 text-sm text-gray-500 text-right">{{ $item->entries }}</td>
                                        <td class="px-5 py-3 text-sm text-red-600 text-right font-semibold">Rp {{ number_format($item->total_amount) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4/dist/chart.umd.min.js"></script>
    <script>
        new Chart(document.getElementById('financeChart'), {
            type: 'line',
            data: {
                labels: @json($chartData['labels']),
                datasets: [
                    {
                        label: 'Pemasukan',
                        data: @json($chartData['sales']),
                        borderColor: 'rgb(16, 185, 129)',
                        backgroundColor: 'rgba(16, 185, 129, 0.1)',
                        fill: true,
                        tension: 0.3,
                        pointRadius: 2,
                    },
                    {
                        label: 'Pengeluaran',
                        data: @json($chartData['expenses']),
                        borderColor: 'rgb(239, 68, 68)',
                        backgroundColor: 'rgba(239, 68, 68, 0.1)',
                        fill: true,
                        tension: 0.3,
                        pointRadius: 2,
                    }
                ]
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
