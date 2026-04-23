<x-app-layout>
    <x-slot name="header">Edit Pembelian Pakan</x-slot>

    <div class="max-w-2xl">
        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <form method="POST" action="{{ route('feed-purchases.update', $feedPurchase) }}">
                @csrf
                @method('PUT')
                <div class="space-y-5">
                    <div>
                        <x-input-label for="feed_stock_id" value="Jenis Pakan" />
                        <select id="feed_stock_id" name="feed_stock_id" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            <option value="">-- Pilih Jenis Pakan --</option>
                            @foreach($feedStocks as $stock)
                                <option value="{{ $stock->id }}" @selected(old('feed_stock_id', $feedPurchase->feed_stock_id) == $stock->id)>{{ $stock->feed_type }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('feed_stock_id')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="date" value="Tanggal Pembelian" />
                        <x-text-input id="date" class="block mt-1 w-full" type="date" name="date" :value="old('date', $feedPurchase->date->format('Y-m-d'))" required />
                        <x-input-error :messages="$errors->get('date')" class="mt-2" />
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <x-input-label for="quantity_kg" value="Jumlah (kg)" />
                            <x-text-input id="quantity_kg" class="block mt-1 w-full" type="number" step="0.01" name="quantity_kg" :value="old('quantity_kg', $feedPurchase->quantity_kg)" required min="0.01" />
                            <x-input-error :messages="$errors->get('quantity_kg')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="total_cost" value="Total Biaya (Rp)" />
                            <x-text-input id="total_cost" class="block mt-1 w-full" type="number" step="1" name="total_cost" :value="old('total_cost', $feedPurchase->total_cost)" required min="0" />
                            <x-input-error :messages="$errors->get('total_cost')" class="mt-2" />
                        </div>
                    </div>

                    <div>
                        <x-input-label for="notes" value="Catatan (opsional)" />
                        <textarea id="notes" name="notes" rows="2" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('notes', $feedPurchase->notes) }}</textarea>
                        <x-input-error :messages="$errors->get('notes')" class="mt-2" />
                    </div>
                </div>
                <div class="flex items-center justify-between mt-6 pt-6 border-t border-gray-200">
                    <a href="{{ route('feed-purchases.index') }}" class="text-sm text-gray-600 hover:text-gray-900">Batal</a>
                    <x-primary-button>Simpan Perubahan</x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
