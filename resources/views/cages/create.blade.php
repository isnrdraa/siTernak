<x-app-layout>
    <x-slot name="header">Tambah Kandang</x-slot>

    <div class="max-w-2xl">
        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <form method="POST" action="{{ route('cages.store') }}">
                @csrf
                <div class="space-y-5">
                    <div>
                        <x-input-label for="name" value="Nama Kandang" />
                        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required placeholder="cth: Kandang A1" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="location" value="Lokasi (opsional)" />
                        <x-text-input id="location" class="block mt-1 w-full" type="text" name="location" :value="old('location')" placeholder="cth: Area Timur, Blok B" />
                        <x-input-error :messages="$errors->get('location')" class="mt-2" />
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <x-input-label for="capacity" value="Kapasitas Maksimal" />
                            <x-text-input id="capacity" class="block mt-1 w-full" type="number" name="capacity" :value="old('capacity')" required min="1" placeholder="cth: 2000" />
                            <x-input-error :messages="$errors->get('capacity')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="status" value="Status" />
                            <select id="status" name="status" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                <option value="active" @selected(old('status', 'active') === 'active')>Aktif</option>
                                <option value="inactive" @selected(old('status') === 'inactive')>Tidak Aktif</option>
                                <option value="maintenance" @selected(old('status') === 'maintenance')>Perawatan</option>
                            </select>
                            <x-input-error :messages="$errors->get('status')" class="mt-2" />
                        </div>
                    </div>

                    <div>
                        <x-input-label for="notes" value="Catatan (opsional)" />
                        <textarea id="notes" name="notes" rows="2" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('notes') }}</textarea>
                        <x-input-error :messages="$errors->get('notes')" class="mt-2" />
                    </div>
                </div>
                <div class="flex items-center justify-between mt-6 pt-6 border-t border-gray-200">
                    <a href="{{ route('cages.index') }}" class="text-sm text-gray-600 hover:text-gray-900">Batal</a>
                    <x-primary-button>Simpan Kandang</x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
