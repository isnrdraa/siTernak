<x-app-layout>
    <x-slot name="header">Stok Pakan</x-slot>

    <div class="space-y-4">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <p class="text-sm text-gray-500">Master jenis pakan dan saldo stok saat ini.</p>
            @can('manage-feed-stock')
                <a href="{{ route('feed-stocks.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-600 text-white text-sm font-medium rounded-lg hover:bg-emerald-700 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                    Tambah Jenis Pakan
                </a>
            @endcan
        </div>

        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
            @if($stocks->isEmpty())
                <div class="px-5 py-12 text-center text-gray-500">
                    <p class="text-sm">Belum ada data jenis pakan.</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jenis Pakan</th>
                                <th class="px-5 py-3 text-right text-xs font-medium text-gray-500 uppercase">Stok Saat Ini</th>
                                <th class="px-5 py-3 text-right text-xs font-medium text-gray-500 uppercase">Stok Minimum</th>
                                <th class="px-5 py-3 text-right text-xs font-medium text-gray-500 uppercase">Harga/kg</th>
                                <th class="px-5 py-3 text-center text-xs font-medium text-gray-500 uppercase">Status</th>
                                <th class="px-5 py-3 text-right text-xs font-medium text-gray-500 uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($stocks as $stock)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-5 py-3 text-sm font-medium text-gray-900">{{ $stock->feed_type }}</td>
                                    <td class="px-5 py-3 text-sm text-right font-semibold {{ $stock->isLowStock() ? 'text-red-600' : 'text-gray-900' }}">{{ number_format($stock->current_stock_kg, 1) }} kg</td>
                                    <td class="px-5 py-3 text-sm text-gray-500 text-right">{{ number_format($stock->min_stock_kg, 1) }} kg</td>
                                    <td class="px-5 py-3 text-sm text-gray-700 text-right">{{ $stock->unit_price ? 'Rp ' . number_format($stock->unit_price) : '-' }}</td>
                                    <td class="px-5 py-3 text-center">
                                        @if($stock->isLowStock())
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-700">Stok Rendah</span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-700">Aman</span>
                                        @endif
                                    </td>
                                    <td class="px-5 py-3 text-right">
                                        <div class="flex items-center justify-end gap-2">
                                            @can('manage-feed-stock')
                                                <a href="{{ route('feed-stocks.edit', $stock) }}" class="text-sm text-blue-600 hover:text-blue-700">Edit</a>
                                                <form method="POST" action="{{ route('feed-stocks.destroy', $stock) }}" onsubmit="return confirm('Yakin hapus jenis pakan ini?')">
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
            @endif
        </div>
    </div>
</x-app-layout>
