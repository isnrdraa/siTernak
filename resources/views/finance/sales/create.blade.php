<x-app-layout>
    <x-slot name="header">Catat Penjualan</x-slot>

    <div class="max-w-2xl">
        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <form method="POST" action="{{ route('sales.store') }}">
                @csrf
                <div class="space-y-5">
                    <div>
                        <x-input-label for="product_id" value="Produk" />
                        <select id="product_id" name="product_id" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required
                                onchange="let o=this.options[this.selectedIndex]; document.getElementById('unit_price').value=o.dataset.price||''; document.getElementById('unit_label').textContent=o.dataset.unit||'satuan'">
                            <option value="">-- Pilih Produk --</option>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}" data-price="{{ $product->price_per_unit }}" data-unit="{{ $product->unit }}" @selected(old('product_id') == $product->id)>{{ $product->name }} ({{ $product->unit }}, Rp {{ number_format($product->price_per_unit) }})</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('product_id')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="date" value="Tanggal" />
                        <x-text-input id="date" class="block mt-1 w-full" type="date" name="date" :value="old('date', now()->format('Y-m-d'))" required />
                        <x-input-error :messages="$errors->get('date')" class="mt-2" />
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <x-input-label for="quantity">Jumlah (<span id="unit_label">satuan</span>)</x-input-label>
                            <x-text-input id="quantity" class="block mt-1 w-full" type="number" step="0.01" name="quantity" :value="old('quantity')" required min="0.01" />
                            <x-input-error :messages="$errors->get('quantity')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="unit_price" value="Harga Satuan (Rp)" />
                            <x-text-input id="unit_price" class="block mt-1 w-full" type="number" step="1" name="unit_price" :value="old('unit_price')" required min="0" />
                            <x-input-error :messages="$errors->get('unit_price')" class="mt-2" />
                        </div>
                    </div>

                    <div>
                        <x-input-label for="buyer_name" value="Nama Pembeli (opsional)" />
                        <x-text-input id="buyer_name" class="block mt-1 w-full" type="text" name="buyer_name" :value="old('buyer_name')" placeholder="cth: Toko Pak Ahmad" />
                        <x-input-error :messages="$errors->get('buyer_name')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="notes" value="Catatan (opsional)" />
                        <textarea id="notes" name="notes" rows="2" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('notes') }}</textarea>
                        <x-input-error :messages="$errors->get('notes')" class="mt-2" />
                    </div>
                </div>
                <div class="flex items-center justify-between mt-6 pt-6 border-t border-gray-200">
                    <a href="{{ route('sales.index') }}" class="text-sm text-gray-600 hover:text-gray-900">Batal</a>
                    <x-primary-button>Simpan Penjualan</x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
