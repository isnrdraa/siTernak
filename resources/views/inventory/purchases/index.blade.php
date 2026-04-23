<x-app-layout>
    <x-slot name="header">Pembelian Pakan</x-slot>

    <div class="space-y-4">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <p class="text-sm text-gray-500">Catatan pembelian pakan masuk.</p>
            @can('create-feed-purchase')
                <a href="{{ route('feed-purchases.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-600 text-white text-sm font-medium rounded-lg hover:bg-emerald-700 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                    Catat Pembelian
                </a>
            @endcan
        </div>

        <form method="GET" class="bg-white rounded-xl border border-gray-200 p-4">
            <div class="flex flex-wrap items-end gap-3">
                <div>
                    <x-input-label for="filter_stock" value="Jenis Pakan" />
                    <select id="filter_stock" name="feed_stock_id" class="block mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                        <option value="">Semua</option>
                        @foreach($feedStocks as $stock)
                            <option value="{{ $stock->id }}" @selected(request('feed_stock_id') == $stock->id)>{{ $stock->feed_type }}</option>
                        @endforeach
                    </select>
                </div>
                <x-primary-button class="h-10">Filter</x-primary-button>
                @if(request()->hasAny(['feed_stock_id']))
                    <a href="{{ route('feed-purchases.index') }}" class="text-sm text-gray-500 hover:text-gray-700 h-10 flex items-center">Reset</a>
                @endif
            </div>
        </form>

        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
            @if($purchases->isEmpty())
                <div class="px-5 py-12 text-center text-gray-500">
                    <p class="text-sm">Belum ada data pembelian pakan.</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                                <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jenis Pakan</th>
                                <th class="px-5 py-3 text-right text-xs font-medium text-gray-500 uppercase">Jumlah (kg)</th>
                                <th class="px-5 py-3 text-right text-xs font-medium text-gray-500 uppercase">Total Biaya</th>
                                <th class="px-5 py-3 text-right text-xs font-medium text-gray-500 uppercase">Harga/kg</th>
                                <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase">Dicatat</th>
                                <th class="px-5 py-3 text-right text-xs font-medium text-gray-500 uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($purchases as $purchase)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-5 py-3 text-sm text-gray-900">{{ $purchase->date->format('d M Y') }}</td>
                                    <td class="px-5 py-3 text-sm text-gray-700">{{ $purchase->feedStock->feed_type }}</td>
                                    <td class="px-5 py-3 text-sm text-gray-900 text-right font-semibold">{{ number_format($purchase->quantity_kg, 1) }}</td>
                                    <td class="px-5 py-3 text-sm text-gray-900 text-right">Rp {{ number_format($purchase->total_cost) }}</td>
                                    <td class="px-5 py-3 text-sm text-gray-500 text-right">Rp {{ $purchase->quantity_kg > 0 ? number_format($purchase->total_cost / $purchase->quantity_kg) : 0 }}</td>
                                    <td class="px-5 py-3 text-sm text-gray-500">{{ $purchase->recorder->name }}</td>
                                    <td class="px-5 py-3 text-right">
                                        <div class="flex items-center justify-end gap-2">
                                            @can('create-feed-purchase')
                                                <a href="{{ route('feed-purchases.edit', $purchase) }}" class="text-sm text-blue-600 hover:text-blue-700">Edit</a>
                                                <form method="POST" action="{{ route('feed-purchases.destroy', $purchase) }}" onsubmit="return confirm('Yakin hapus data ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-sm text-red-600 hover:text-red-700">Hapus</button>
                                                </form>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="px-5 py-3 border-t border-gray-200">
                    {{ $purchases->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
