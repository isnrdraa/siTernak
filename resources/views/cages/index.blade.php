<x-app-layout>
    <x-slot name="header">Kandang</x-slot>

    <div class="space-y-4">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <p class="text-sm text-gray-500">Data master kandang dan jumlah isi ternak.</p>
            @can('manage-cages')
                <a href="{{ route('cages.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-600 text-white text-sm font-medium rounded-lg hover:bg-emerald-700 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                    Tambah Kandang
                </a>
            @endcan
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @forelse($cages as $cage)
                <div class="bg-white rounded-xl border border-gray-200 p-5 hover:shadow-md transition-shadow">
                    <div class="flex items-start justify-between mb-3">
                        <div>
                            <h3 class="text-sm font-semibold text-gray-900">{{ $cage->name }}</h3>
                            @if($cage->location)
                                <p class="text-xs text-gray-500 mt-0.5">{{ $cage->location }}</p>
                            @endif
                        </div>
                        <x-status-badge :status="$cage->status->value" />
                    </div>

                    <div class="mb-3">
                        <div class="flex items-center justify-between text-sm mb-1">
                            <span class="text-gray-600">Isi Kandang</span>
                            <span class="font-semibold {{ $cage->current_count >= $cage->capacity ? 'text-red-600' : 'text-gray-900' }}">{{ number_format($cage->current_count) }} / {{ number_format($cage->capacity) }}</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            @php $pct = $cage->occupancyPercent(); @endphp
                            <div class="h-2 rounded-full {{ $pct >= 90 ? 'bg-red-500' : ($pct >= 70 ? 'bg-amber-500' : 'bg-emerald-500') }}" style="width: {{ min($pct, 100) }}%"></div>
                        </div>
                        <p class="text-xs text-gray-400 mt-1">Sisa ruang: {{ number_format($cage->availableSpace()) }} ekor</p>
                    </div>

                    <div class="flex items-center gap-2 pt-3 border-t border-gray-100">
                        <a href="{{ route('cages.show', $cage) }}" class="text-xs text-emerald-600 hover:text-emerald-700 font-medium">Detail</a>
                        @can('manage-cages')
                            <span class="text-gray-300">|</span>
                            <a href="{{ route('cages.edit', $cage) }}" class="text-xs text-blue-600 hover:text-blue-700">Edit</a>
                            <span class="text-gray-300">|</span>
                            <form method="POST" action="{{ route('cages.destroy', $cage) }}" onsubmit="return confirm('Yakin hapus kandang ini?')" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-xs text-red-600 hover:text-red-700">Hapus</button>
                            </form>
                        @endcan
                    </div>
                </div>
            @empty
                <div class="col-span-full bg-white rounded-xl border border-gray-200 px-5 py-12 text-center text-gray-500">
                    <p class="text-sm">Belum ada data kandang.</p>
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout>
