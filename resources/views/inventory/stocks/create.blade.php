<x-app-layout>
    <x-slot name="header">Tambah Jenis Pakan</x-slot>

    <div class="max-w-2xl">
        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <form method="POST" action="{{ route('feed-stocks.store') }}">
                @csrf
                <div class="space-y-5">
                    <div>
                        <x-input-label for="feed_type" value="Nama Jenis Pakan" />
                        <x-text-input id="feed_type" class="block mt-1 w-full" type="text" name="feed_type" :value="old('feed_type')" required placeholder="cth: Layer Feed, Konsentrat, Jagung" />
                        <x-input-error :messages="$errors->get('feed_type')" class="mt-2" />
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <x-input-label for="min_stock_kg" value="Stok Minimum (kg)" />
                            <x-text-input id="min_stock_kg" class="block mt-1 w-full" type="number" step="0.1" name="min_stock_kg" :value="old('min_stock_kg', 100)" required min="0" />
                            <x-input-error :messages="$errors->get('min_stock_kg')" class="mt-2" />
                            <p class="text-xs text-gray-500 mt-1">Alert akan muncul jika stok di bawah nilai ini.</p>
                        </div>
                        <div>
                            <x-input-label for="unit_price" value="Harga per kg (opsional)" />
                            <x-text-input id="unit_price" class="block mt-1 w-full" type="number" step="1" name="unit_price" :value="old('unit_price')" min="0" placeholder="cth: 8500" />
                            <x-input-error :messages="$errors->get('unit_price')" class="mt-2" />
                        </div>
                    </div>
                </div>
                <div class="flex items-center justify-between mt-6 pt-6 border-t border-gray-200">
                    <a href="{{ route('feed-stocks.index') }}" class="text-sm text-gray-600 hover:text-gray-900">Batal</a>
                    <x-primary-button>Simpan</x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
