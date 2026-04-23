<x-app-layout>
    <x-slot name="header">Detail Kandang: {{ $cage->name }}</x-slot>

    <div class="space-y-6">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="bg-white rounded-xl border border-gray-200 p-5">
                <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">Info Kandang</h3>
                <dl class="space-y-2">
                    <div class="flex justify-between">
                        <dt class="text-sm text-gray-500">Nama</dt>
                        <dd class="text-sm font-medium text-gray-900">{{ $cage->name }}</dd>
                    </div>
                    @if($cage->location)
                        <div class="flex justify-between">
                            <dt class="text-sm text-gray-500">Lokasi</dt>
                            <dd class="text-sm text-gray-900">{{ $cage->location }}</dd>
                        </div>
                    @endif
                    <div class="flex justify-between">
                        <dt class="text-sm text-gray-500">Status</dt>
                        <dd><x-status-badge :status="$cage->status->value" /></dd>
                    </div>
                    @if($cage->notes)
                        <div class="pt-2 border-t border-gray-100">
                            <dt class="text-xs text-gray-400 mb-1">Catatan</dt>
                            <dd class="text-sm text-gray-700">{{ $cage->notes }}</dd>
                        </div>
                    @endif
                </dl>
            </div>

            <div class="bg-white rounded-xl border border-gray-200 p-5">
                <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">Kapasitas</h3>
                <div class="text-center py-4">
                    <p class="text-3xl font-bold {{ $cage->current_count >= $cage->capacity ? 'text-red-600' : 'text-gray-900' }}">{{ number_format($cage->current_count) }}</p>
                    <p class="text-sm text-gray-500">dari {{ number_format($cage->capacity) }} kapasitas</p>
                    <div class="w-full bg-gray-200 rounded-full h-3 mt-3">
                        @php $pct = $cage->occupancyPercent(); @endphp
                        <div class="h-3 rounded-full {{ $pct >= 90 ? 'bg-red-500' : ($pct >= 70 ? 'bg-amber-500' : 'bg-emerald-500') }}" style="width: {{ min($pct, 100) }}%"></div>
                    </div>
                    <p class="text-xs text-gray-400 mt-2">{{ $pct }}% terisi &middot; Sisa {{ number_format($cage->availableSpace()) }} ekor</p>
                </div>
            </div>

            @can('manage-cages')
                <div class="bg-white rounded-xl border border-gray-200 p-5">
                    <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">Tambah Ternak</h3>
                    <form method="POST" action="{{ route('cages.add-stock', $cage) }}">
                        @csrf
                        <div class="space-y-3">
                            <div>
                                <x-input-label for="quantity" value="Jumlah (ekor)" />
                                <x-text-input id="quantity" class="block mt-1 w-full" type="number" name="quantity" min="1" :max="$cage->availableSpace()" required placeholder="cth: 100" />
                                <x-input-error :messages="$errors->get('quantity')" class="mt-1" />
                            </div>
                            <div>
                                <x-input-label for="description" value="Keterangan (opsional)" />
                                <x-text-input id="description" class="block mt-1 w-full" type="text" name="description" placeholder="cth: Pembelian DOC batch baru" />
                            </div>
                            <x-primary-button class="w-full justify-center">Tambahkan</x-primary-button>
                        </div>
                    </form>
                </div>
            @endcan
        </div>

        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
            <div class="px-5 py-4 border-b border-gray-200">
                <h3 class="text-sm font-semibold text-gray-900">Riwayat Pergerakan Stok</h3>
            </div>
            @if($movements->isEmpty())
                <div class="px-5 py-8 text-center text-gray-500 text-sm">Belum ada riwayat pergerakan.</div>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                                <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tipe</th>
                                <th class="px-5 py-3 text-right text-xs font-medium text-gray-500 uppercase">Jumlah</th>
                                <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase">Keterangan</th>
                                <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase">Dicatat</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($movements as $mv)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-5 py-3 text-sm text-gray-900">{{ $mv->date->format('d M Y') }}</td>
                                    <td class="px-5 py-3">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $mv->type->isIncrease() ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">{{ $mv->type->label() }}</span>
                                    </td>
                                    <td class="px-5 py-3 text-sm text-right font-semibold {{ $mv->type->isIncrease() ? 'text-green-600' : 'text-red-600' }}">
                                        {{ $mv->type->isIncrease() ? '+' : '-' }}{{ number_format($mv->quantity) }}
                                    </td>
                                    <td class="px-5 py-3 text-sm text-gray-600">{{ $mv->description ?? '-' }}</td>
                                    <td class="px-5 py-3 text-sm text-gray-500">{{ $mv->recorder->name }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="px-5 py-3 border-t border-gray-200">{{ $movements->links() }}</div>
            @endif
        </div>

        <div class="flex gap-3">
            <a href="{{ route('cages.index') }}" class="text-sm text-gray-600 hover:text-gray-900">Kembali ke daftar kandang</a>
        </div>
    </div>
</x-app-layout>
