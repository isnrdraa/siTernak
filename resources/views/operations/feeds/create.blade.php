<x-app-layout>
    <x-slot name="header">Catat Konsumsi Pakan</x-slot>

    <div class="max-w-2xl">
        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <form method="POST" action="{{ route('feed-logs.store') }}">
                @csrf
                <div class="space-y-5">
                    <div>
                        <x-input-label for="cage_id" value="Kandang" />
                        <select id="cage_id" name="cage_id" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            <option value="">-- Pilih Kandang --</option>
                            @foreach($cages as $cage)
                                <option value="{{ $cage->id }}" @selected(old('cage_id') == $cage->id)>{{ $cage->name }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('cage_id')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="date" value="Tanggal" />
                        <x-text-input id="date" class="block mt-1 w-full" type="date" name="date" :value="old('date', now()->format('Y-m-d'))" required />
                        <x-input-error :messages="$errors->get('date')" class="mt-2" />
                    </div>

                    @if(isset($feedStocks) && $feedStocks->isNotEmpty())
                        <div>
                            <x-input-label for="feed_stock_id" value="Ambil dari Stok Pakan (opsional)" />
                            <select id="feed_stock_id" name="feed_stock_id" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    onchange="if(this.value){document.getElementById('feed_type').value=this.options[this.selectedIndex].dataset.type}">
                                <option value="">-- Manual / Tanpa Stok --</option>
                                @foreach($feedStocks as $fs)
                                    <option value="{{ $fs->id }}" data-type="{{ $fs->feed_type }}" @selected(old('feed_stock_id') == $fs->id)>{{ $fs->feed_type }} ({{ number_format($fs->current_stock_kg, 1) }} kg)</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('feed_stock_id')" class="mt-2" />
                        </div>
                    @endif

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <x-input-label for="feed_type" value="Jenis Pakan" />
                            <x-text-input id="feed_type" class="block mt-1 w-full" type="text" name="feed_type" :value="old('feed_type')" required placeholder="cth: Layer Feed, Konsentrat" />
                            <x-input-error :messages="$errors->get('feed_type')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="quantity_kg" value="Jumlah (kg)" />
                            <x-text-input id="quantity_kg" class="block mt-1 w-full" type="number" step="0.01" name="quantity_kg" :value="old('quantity_kg')" required min="0.01" placeholder="cth: 150.5" />
                            <x-input-error :messages="$errors->get('quantity_kg')" class="mt-2" />
                        </div>
                    </div>

                    <div>
                        <x-input-label for="notes" value="Catatan (opsional)" />
                        <textarea id="notes" name="notes" rows="2" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('notes') }}</textarea>
                        <x-input-error :messages="$errors->get('notes')" class="mt-2" />
                    </div>
                </div>
                <div class="flex items-center justify-between mt-6 pt-6 border-t border-gray-200">
                    <a href="{{ route('feed-logs.index') }}" class="text-sm text-gray-600 hover:text-gray-900">Batal</a>
                    <x-primary-button>Simpan Pakan</x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
