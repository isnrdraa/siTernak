<x-app-layout>
    <x-slot name="header">Catat Kematian</x-slot>

    <div class="max-w-2xl">
        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <form method="POST" action="{{ route('mortality-logs.store') }}">
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

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <x-input-label for="count" value="Jumlah Kematian (ekor)" />
                            <x-text-input id="count" class="block mt-1 w-full" type="number" name="count" :value="old('count')" required min="1" placeholder="cth: 5" />
                            <x-input-error :messages="$errors->get('count')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="cause" value="Penyebab (opsional)" />
                            <x-text-input id="cause" class="block mt-1 w-full" type="text" name="cause" :value="old('cause')" placeholder="cth: Penyakit, Heat Stress" />
                            <x-input-error :messages="$errors->get('cause')" class="mt-2" />
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-between mt-6 pt-6 border-t border-gray-200">
                    <a href="{{ route('mortality-logs.index') }}" class="text-sm text-gray-600 hover:text-gray-900">Batal</a>
                    <x-primary-button>Simpan Kematian</x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
