<x-app-layout>
    <x-slot name="header">Catat Kesehatan</x-slot>

    <div class="max-w-2xl">
        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <form method="POST" action="{{ route('health-logs.store') }}">
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

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <x-input-label for="date" value="Tanggal" />
                            <x-text-input id="date" class="block mt-1 w-full" type="date" name="date" :value="old('date', now()->format('Y-m-d'))" required />
                            <x-input-error :messages="$errors->get('date')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="type" value="Jenis Kejadian" />
                            <select id="type" name="type" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                <option value="">-- Pilih Jenis --</option>
                                <option value="Vaccination" @selected(old('type') === 'Vaccination')>Vaksinasi</option>
                                <option value="Treatment" @selected(old('type') === 'Treatment')>Perawatan</option>
                                <option value="Checkup" @selected(old('type') === 'Checkup')>Pemeriksaan</option>
                                <option value="Disease" @selected(old('type') === 'Disease')>Penyakit</option>
                            </select>
                            <x-input-error :messages="$errors->get('type')" class="mt-2" />
                        </div>
                    </div>

                    <div>
                        <x-input-label for="description" value="Keterangan (opsional)" />
                        <textarea id="description" name="description" rows="3" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Jelaskan kondisi atau gejala yang ditemukan...">{{ old('description') }}</textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="treatment" value="Tindakan / Pengobatan (opsional)" />
                        <textarea id="treatment" name="treatment" rows="2" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Tindakan yang dilakukan...">{{ old('treatment') }}</textarea>
                        <x-input-error :messages="$errors->get('treatment')" class="mt-2" />
                    </div>
                </div>

                <div class="flex items-center justify-between mt-6 pt-6 border-t border-gray-200">
                    <a href="{{ route('health-logs.index') }}" class="text-sm text-gray-600 hover:text-gray-900">Batal</a>
                    <x-primary-button>Simpan Kesehatan</x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
