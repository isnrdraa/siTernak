<x-guest-layout>
    <div class="text-center mb-6">
        <h2 class="text-xl font-bold text-gray-900">Buat Usaha Baru</h2>
        <p class="mt-1 text-sm text-gray-500">Daftarkan peternakan Anda di SiTernak</p>
    </div>

    <form method="POST" action="{{ route('tenant.store') }}">
        @csrf

        <div>
            <x-input-label for="name" value="Nama Usaha / Peternakan" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus placeholder="cth: Peternakan Sejahtera" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between mt-6">
            <a href="{{ route('tenant.select') }}" class="text-sm text-gray-600 hover:text-gray-900">
                Kembali
            </a>
            <x-primary-button>
                Buat Usaha
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
