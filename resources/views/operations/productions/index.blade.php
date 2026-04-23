<x-app-layout>
    <x-slot name="header">Produksi Harian</x-slot>

    <div class="space-y-4">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <p class="text-sm text-gray-500">Pencatatan produksi harian per kandang.</p>
            @can('create-production')
                <a href="{{ route('productions.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-600 text-white text-sm font-medium rounded-lg hover:bg-emerald-700 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                    Catat Produksi
                </a>
            @endcan
        </div>

        <form method="GET" class="bg-white rounded-xl border border-gray-200 p-4">
            <div class="flex flex-wrap items-end gap-3">
                <div>
                    <x-input-label for="filter_date" value="Tanggal" />
                    <x-text-input id="filter_date" class="block mt-1" type="date" name="date" :value="request('date')" />
                </div>
                <div>
                    <x-input-label for="filter_cage" value="Kandang" />
                    <select id="filter_cage" name="cage_id" class="block mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                        <option value="">Semua</option>
                        @foreach($cages as $cage)
                            <option value="{{ $cage->id }}" @selected(request('cage_id') == $cage->id)>{{ $cage->name }}</option>
                        @endforeach
                    </select>
                </div>
                <x-primary-button class="h-10">Filter</x-primary-button>
                @if(request()->hasAny(['date', 'cage_id']))
                    <a href="{{ route('productions.index') }}" class="text-sm text-gray-500 hover:text-gray-700 h-10 flex items-center">Reset</a>
                @endif
            </div>
        </form>

        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
            @if($productions->isEmpty())
                <div class="px-5 py-12 text-center text-gray-500"><p class="text-sm">Belum ada data produksi.</p></div>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                                <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kandang</th>
                                <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase">Produk</th>
                                <th class="px-5 py-3 text-right text-xs font-medium text-gray-500 uppercase">Jumlah</th>
                                <th class="px-5 py-3 text-right text-xs font-medium text-gray-500 uppercase">Rusak</th>
                                <th class="px-5 py-3 text-right text-xs font-medium text-gray-500 uppercase">Baik</th>
                                <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase">Dicatat</th>
                                <th class="px-5 py-3 text-center text-xs font-medium text-gray-500 uppercase">Validasi</th>
                                <th class="px-5 py-3 text-right text-xs font-medium text-gray-500 uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($productions as $prod)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-5 py-3 text-sm text-gray-900">{{ $prod->date->format('d M Y') }}</td>
                                    <td class="px-5 py-3 text-sm text-gray-700">{{ $prod->cage->name }}</td>
                                    <td class="px-5 py-3 text-sm text-gray-700">{{ $prod->product->name }}</td>
                                    <td class="px-5 py-3 text-sm text-gray-900 text-right font-semibold">{{ number_format($prod->quantity, 2) }} {{ $prod->product->unit }}</td>
                                    <td class="px-5 py-3 text-sm text-red-600 text-right">{{ number_format($prod->damaged_count, 2) }}</td>
                                    <td class="px-5 py-3 text-sm text-emerald-600 text-right font-medium">{{ number_format($prod->goodCount(), 2) }}</td>
                                    <td class="px-5 py-3 text-sm text-gray-500">{{ $prod->recorder->name }}</td>
                                    <td class="px-5 py-3 text-center">
                                        @if($prod->isValidated())
                                            <span class="inline-flex items-center gap-1 text-xs text-green-700">
                                                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                                {{ $prod->validator->name }}
                                            </span>
                                        @else
                                            @can('validate-production')
                                                <form method="POST" action="{{ route('productions.validate', $prod) }}">
                                                    @csrf @method('PATCH')
                                                    <button type="submit" class="text-xs font-medium text-amber-600 hover:text-amber-700">Validasi</button>
                                                </form>
                                            @else
                                                <span class="text-xs text-gray-400">Belum</span>
                                            @endcan
                                        @endif
                                    </td>
                                    <td class="px-5 py-3 text-right">
                                        <div class="flex items-center justify-end gap-2">
                                            @can('create-production')
                                                <a href="{{ route('productions.edit', $prod) }}" class="text-sm text-blue-600 hover:text-blue-700">Edit</a>
                                            @endcan
                                            @can('validate-production')
                                                <form method="POST" action="{{ route('productions.destroy', $prod) }}" onsubmit="return confirm('Yakin hapus data ini?')">
                                                    @csrf @method('DELETE')
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
                <div class="px-5 py-3 border-t border-gray-200">{{ $productions->links() }}</div>
            @endif
        </div>
    </div>
</x-app-layout>
