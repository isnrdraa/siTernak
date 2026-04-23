<x-app-layout>
    <x-slot name="header">Catat Produksi Harian</x-slot>

    <div class="max-w-2xl">
        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <form method="POST" action="{{ route('productions.store') }}">
                @csrf
                <div class="space-y-5">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <x-input-label for="cage_id" value="Kandang" />
                            <select id="cage_id" name="cage_id" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                <option value="">-- Pilih Kandang --</option>
                                @foreach($cages as $cage)
                                    <option value="{{ $cage->id }}" @selected(old('cage_id') == $cage->id)>{{ $cage->name }} ({{ $cage->current_count }} ekor)</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('cage_id')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="product_id" value="Produk" />
                            <select id="product_id" name="product_id" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                <option value="">-- Pilih Produk --</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}" data-unit="{{ $product->unit }}" @selected(old('product_id') == $product->id)>{{ $product->name }} ({{ $product->unit }})</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('product_id')" class="mt-2" />
                        </div>
                    </div>

                    <div>
                        <x-input-label for="date" value="Tanggal" />
                        <x-text-input id="date" class="block mt-1 w-full" type="date" name="date" :value="old('date', now()->format('Y-m-d'))" required />
                        <x-input-error :messages="$errors->get('date')" class="mt-2" />
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <x-input-label for="quantity" value="Jumlah Produksi" />
                            <x-text-input id="quantity" class="block mt-1 w-full" type="number" step="0.01" name="quantity" :value="old('quantity')" required min="0" placeholder="cth: 1500" />
                            <x-input-error :messages="$errors->get('quantity')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="damaged_count" value="Jumlah Rusak" />
                            <x-text-input id="damaged_count" class="block mt-1 w-full" type="number" step="0.01" name="damaged_count" :value="old('damaged_count', 0)" required min="0" />
                            <x-input-error :messages="$errors->get('damaged_count')" class="mt-2" />
                        </div>
                    </div>

                    <div>
                        <x-input-label for="notes" value="Catatan (opsional)" />
                        <textarea id="notes" name="notes" rows="2" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('notes') }}</textarea>
                        <x-input-error :messages="$errors->get('notes')" class="mt-2" />
                    </div>
                </div>
                <div class="flex items-center justify-between mt-6 pt-6 border-t border-gray-200">
                    <a href="{{ route('productions.index') }}" class="text-sm text-gray-600 hover:text-gray-900">Batal</a>
                    <x-primary-button>Simpan Produksi</x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
