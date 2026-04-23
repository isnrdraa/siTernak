<x-app-layout>
    <x-slot name="header">Dashboard</x-slot>

    <div class="space-y-6">
        {{-- KPI Cards --}}
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="bg-white rounded-xl border border-gray-200 p-5">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-10 h-10 bg-amber-50 text-amber-600 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">Produksi Hari Ini</p>
                    </div>
                </div>
                @if($todayProductions->isEmpty())
                    <p class="text-sm text-gray-400">Belum ada produksi</p>
                @else
                    <div class="space-y-1">
                        @foreach($todayProductions->take(5) as $tp)
                            <div class="flex items-center justify-between">
                                <span class="text-xs text-gray-600 truncate mr-2">{{ $tp->product->name }}</span>
                                <span class="text-xs font-semibold text-gray-900 whitespace-nowrap">{{ number_format($tp->total_qty, 0) }} {{ $tp->product->unit }}</span>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <x-stats-card title="Total Ternak" :value="number_format($stats['total_ternak']) . ' ekor'" color="emerald">
                <x-slot name="icon"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg></x-slot>
                {{ $stats['total_cages'] }} kandang
            </x-stats-card>

            <x-stats-card title="Pakan Hari Ini" :value="number_format($stats['today_feed_kg'], 1) . ' kg'" color="blue">
                <x-slot name="icon"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg></x-slot>
            </x-stats-card>

            <x-stats-card title="Kematian 7 Hari" :value="$stats['week_mortality'] . ' ekor'" :color="$stats['week_mortality'] > 0 ? 'red' : 'gray'">
                <x-slot name="icon"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg></x-slot>
                Hari ini: {{ $stats['today_mortality'] }} ekor
            </x-stats-card>
        </div>

        {{-- Charts Row --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-white rounded-xl border border-gray-200 p-5">
                <h3 class="text-sm font-semibold text-gray-900 mb-4">Tren Produksi (7 Hari)</h3>
                <div class="h-56">
                    <canvas id="productionChart"></canvas>
                </div>
            </div>

            <div class="bg-white rounded-xl border border-gray-200 p-5">
                <h3 class="text-sm font-semibold text-gray-900 mb-4">Pakan & Kematian (7 Hari)</h3>
                <div class="h-56">
                    <canvas id="feedMortalityChart"></canvas>
                </div>
            </div>
        </div>

        {{-- Low Stock Alert + Finance Summary --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            @if(isset($lowStocks) && $lowStocks->isNotEmpty())
                <div class="bg-white rounded-xl border border-red-200 overflow-hidden">
                    <div class="px-5 py-4 border-b border-red-100 bg-red-50 flex items-center gap-2">
                        <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                        <h3 class="text-sm font-semibold text-red-800">Stok Pakan Rendah</h3>
                    </div>
                    <div class="divide-y divide-gray-100">
                        @foreach($lowStocks as $stock)
                            <div class="px-5 py-3 flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-900">{{ $stock->feed_type }}</p>
                                    <p class="text-xs text-gray-500">Minimum: {{ number_format($stock->min_stock_kg, 1) }} kg</p>
                                </div>
                                <span class="text-sm font-bold text-red-600">{{ number_format($stock->current_stock_kg, 1) }} kg</span>
                            </div>
                        @endforeach
                    </div>
                    <div class="px-5 py-3 border-t border-gray-100 bg-gray-50">
                        <a href="{{ route('feed-stocks.index') }}" class="text-xs text-emerald-600 hover:text-emerald-700">Kelola stok pakan</a>
                    </div>
                </div>
            @endif

            @if(isset($financeSummary))
                <div class="bg-white rounded-xl border border-gray-200 overflow-hidden {{ isset($lowStocks) && $lowStocks->isNotEmpty() ? '' : 'lg:col-span-2' }}">
                    <div class="px-5 py-4 border-b border-gray-200 flex items-center justify-between">
                        <h3 class="text-sm font-semibold text-gray-900">Ringkasan Keuangan Bulan Ini</h3>
                        <a href="{{ route('finance.summary') }}" class="text-xs text-emerald-600 hover:text-emerald-700">Detail</a>
                    </div>
                    <div class="grid grid-cols-3 divide-x divide-gray-100">
                        <div class="px-5 py-4 text-center">
                            <p class="text-xs text-gray-500">Pemasukan</p>
                            <p class="text-sm font-bold text-emerald-600 mt-1">Rp {{ number_format($financeSummary['month_sales']) }}</p>
                        </div>
                        <div class="px-5 py-4 text-center">
                            <p class="text-xs text-gray-500">Pengeluaran</p>
                            <p class="text-sm font-bold text-red-600 mt-1">Rp {{ number_format($financeSummary['month_expenses']) }}</p>
                        </div>
                        <div class="px-5 py-4 text-center">
                            <p class="text-xs text-gray-500">{{ $financeSummary['month_profit'] >= 0 ? 'Laba' : 'Rugi' }}</p>
                            <p class="text-sm font-bold {{ $financeSummary['month_profit'] >= 0 ? 'text-emerald-600' : 'text-red-600' }} mt-1">Rp {{ number_format(abs($financeSummary['month_profit'])) }}</p>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        {{-- Recent Productions + Health Alerts --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                <div class="px-5 py-4 border-b border-gray-200 flex items-center justify-between">
                    <h3 class="text-sm font-semibold text-gray-900">Produksi Terbaru</h3>
                    <a href="{{ route('productions.index') }}" class="text-xs text-emerald-600 hover:text-emerald-700">Lihat semua</a>
                </div>
                @if($recentProductions->isEmpty())
                    <div class="px-5 py-8 text-center text-gray-500"><p class="text-sm">Belum ada data produksi.</p></div>
                @else
                    <div class="divide-y divide-gray-100">
                        @foreach($recentProductions as $prod)
                            <div class="px-5 py-3 flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-900">{{ $prod->cage->name }} — {{ $prod->product->name }}</p>
                                    <p class="text-xs text-gray-500">{{ $prod->date->translatedFormat('d M Y') }} · {{ $prod->recorder->name }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm font-bold text-gray-900">{{ number_format($prod->quantity, 0) }} {{ $prod->product->unit }}</p>
                                    @if($prod->damaged_count > 0)
                                        <p class="text-xs text-red-500">{{ number_format($prod->damaged_count, 0) }} rusak</p>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                <div class="px-5 py-4 border-b border-gray-200 flex items-center justify-between">
                    <h3 class="text-sm font-semibold text-gray-900">Peringatan Penyakit</h3>
                    <a href="{{ route('health-logs.index') }}" class="text-xs text-emerald-600 hover:text-emerald-700">Lihat semua</a>
                </div>
                @if($recentHealthAlerts->isEmpty())
                    <div class="px-5 py-8 text-center text-gray-500"><p class="text-sm">Tidak ada laporan penyakit terbaru.</p></div>
                @else
                    <div class="divide-y divide-gray-100">
                        @foreach($recentHealthAlerts as $alert)
                            <div class="px-5 py-3">
                                <div class="flex items-center justify-between">
                                    <p class="text-sm font-medium text-gray-900">{{ $alert->cage->name }}</p>
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-700">Penyakit</span>
                                </div>
                                <p class="text-xs text-gray-600 mt-1 line-clamp-1">{{ $alert->description ?? 'Tidak ada keterangan' }}</p>
                                <p class="text-xs text-gray-400 mt-0.5">{{ $alert->date->translatedFormat('d M Y') }}</p>
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
        const chartColors = {
            emerald: { bg: 'rgba(16, 185, 129, 0.1)', border: 'rgb(16, 185, 129)' },
            red: { bg: 'rgba(239, 68, 68, 0.1)', border: 'rgb(239, 68, 68)' },
            blue: { bg: 'rgba(59, 130, 246, 0.1)', border: 'rgb(59, 130, 246)' },
        };

        const defaultOptions = {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { position: 'bottom', labels: { boxWidth: 12, padding: 16, font: { size: 11 } } } },
            scales: {
                x: { grid: { display: false }, ticks: { font: { size: 10 } } },
                y: { beginAtZero: true, ticks: { font: { size: 10 } } },
            }
        };

        new Chart(document.getElementById('productionChart'), {
            type: 'line',
            data: {
                labels: @json($chartData['labels']),
                datasets: [{
                    label: 'Catatan Produksi',
                    data: @json($chartData['production']),
                    borderColor: chartColors.emerald.border,
                    backgroundColor: chartColors.emerald.bg,
                    fill: true,
                    tension: 0.3,
                    pointRadius: 3,
                }]
            },
            options: defaultOptions,
        });

        new Chart(document.getElementById('feedMortalityChart'), {
            type: 'bar',
            data: {
                labels: @json($chartData['labels']),
                datasets: [
                    {
                        label: 'Pakan (kg)',
                        data: @json($chartData['feed']),
                        backgroundColor: chartColors.blue.border,
                        borderRadius: 4,
                        yAxisID: 'y',
                    },
                    {
                        label: 'Kematian (ekor)',
                        data: @json($chartData['mortality']),
                        backgroundColor: chartColors.red.border,
                        borderRadius: 4,
                        yAxisID: 'y1',
                    }
                ]
            },
            options: {
                ...defaultOptions,
                scales: {
                    x: { grid: { display: false }, ticks: { font: { size: 10 } } },
                    y: { beginAtZero: true, position: 'left', title: { display: true, text: 'Pakan (kg)', font: { size: 10 } }, ticks: { font: { size: 10 } } },
                    y1: { beginAtZero: true, position: 'right', grid: { drawOnChartArea: false }, title: { display: true, text: 'Kematian', font: { size: 10 } }, ticks: { font: { size: 10 } } },
                },
            },
        });
    </script>
    @endpush
</x-app-layout>
