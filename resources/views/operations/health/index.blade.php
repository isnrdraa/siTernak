<x-app-layout>
    <x-slot name="header">Catatan Kesehatan</x-slot>

    <div class="space-y-4">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <p class="text-sm text-gray-500">Pencatatan kesehatan, vaksinasi, dan perawatan ternak.</p>
            @can('create-health-log')
                <a href="{{ route('health-logs.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-600 text-white text-sm font-medium rounded-lg hover:bg-emerald-700 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                    Catat Kesehatan
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
                <div>
                    <x-input-label for="filter_type" value="Jenis" />
                    <select id="filter_type" name="type" class="block mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                        <option value="">Semua</option>
                        <option value="Vaccination" @selected(request('type') === 'Vaccination')>Vaksinasi</option>
                        <option value="Treatment" @selected(request('type') === 'Treatment')>Perawatan</option>
                        <option value="Checkup" @selected(request('type') === 'Checkup')>Pemeriksaan</option>
                        <option value="Disease" @selected(request('type') === 'Disease')>Penyakit</option>
                    </select>
                </div>
                <x-primary-button class="h-10">Filter</x-primary-button>
                @if(request()->hasAny(['date', 'cage_id', 'type']))
                    <a href="{{ route('health-logs.index') }}" class="text-sm text-gray-500 hover:text-gray-700 h-10 flex items-center">Reset</a>
                @endif
            </div>
        </form>

        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
            @if($healthLogs->isEmpty())
                <div class="px-5 py-12 text-center text-gray-500">
                    <p class="text-sm">Belum ada data kesehatan.</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                                <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kandang</th>
                                <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jenis</th>
                                <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase">Keterangan</th>
                                <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase">Dicatat</th>
                                <th class="px-5 py-3 text-right text-xs font-medium text-gray-500 uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($healthLogs as $log)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-5 py-3 text-sm text-gray-900">{{ $log->date->format('d M Y') }}</td>
                                    <td class="px-5 py-3 text-sm text-gray-700">{{ $log->cage->name }}</td>
                                    <td class="px-5 py-3">
                                        <x-status-badge :status="$log->type" />
                                    </td>
                                    <td class="px-5 py-3 text-sm text-gray-500 max-w-xs truncate">{{ $log->description ?? '-' }}</td>
                                    <td class="px-5 py-3 text-sm text-gray-500">{{ $log->recorder->name }}</td>
                                    <td class="px-5 py-3 text-right">
                                        <div class="flex items-center justify-end gap-2">
                                            @can('create-health-log')
                                                <a href="{{ route('health-logs.edit', $log) }}" class="text-sm text-blue-600 hover:text-blue-700">Edit</a>
                                                <form method="POST" action="{{ route('health-logs.destroy', $log) }}" onsubmit="return confirm('Yakin hapus data ini?')">
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
                    {{ $healthLogs->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
