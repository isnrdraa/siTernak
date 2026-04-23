<x-app-layout>
    <x-slot name="header">Catat Penjualan Hewan</x-slot>

    <div class="max-w-2xl">
        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <form method="POST" action="{{ route('livestock-sales.store') }}">
                @csrf
                <div class="space-y-5">
                    <div>
                        <x-input-label for="cage_id" value="Kandang" />
                        <select id="cage_id" name="cage_id" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            <option value="">-- Pilih Kandang --</option>
                            @foreach($cages as $cage)
                                <option value="{{ $cage->id }}" @selected(old('cage_id') == $cage->id)>{{ $cage->name }} (isi: {{ number_format($cage->current_count) }} ekor)</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('cage_id')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="date" value="Tanggal" />
                        <x-text-input id="date" class="block mt-1 w-full" type="date" name="date" :value="old('date', now()->format('Y-m-d'))" required />
                        <x-input-error :messages="$errors->get('date')" class="mt-2" />
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <x-input-label for="quantity" value="Jumlah (ekor)" />
                            <x-text-input id="quantity" class="block mt-1 w-full" type="number" name="quantity" :value="old('quantity')" required min="1" placeholder="cth: 50" />
                            <x-input-error :messages="$errors->get('quantity')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="price_per_unit" value="Harga per ekor (Rp)" />
                            <x-text-input id="price_per_unit" class="block mt-1 w-full" type="number" step="1" name="price_per_unit" :value="old('price_per_unit')" required min="0" placeholder="cth: 35000" />
                            <x-input-error :messages="$errors->get('price_per_unit')" class="mt-2" />
                        </div>
                    </div>

                    <div>
                        <x-input-label for="buyer_name" value="Nama Pembeli (opsional)" />
                        <x-text-input id="buyer_name" class="block mt-1 w-full" type="text" name="buyer_name" :value="old('buyer_name')" placeholder="cth: Pak Ahmad" />
                        <x-input-error :messages="$errors->get('buyer_name')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="notes" value="Catatan (opsional)" />
                        <textarea id="notes" name="notes" rows="2" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('notes') }}</textarea>
                        <x-input-error :messages="$errors->get('notes')" class="mt-2" />
                    </div>
                </div>
                <div class="flex items-center justify-between mt-6 pt-6 border-t border-gray-200">
                    <a href="{{ route('livestock-sales.index') }}" class="text-sm text-gray-600 hover:text-gray-900">Batal</a>
                    <x-primary-button>Simpan Penjualan</x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
