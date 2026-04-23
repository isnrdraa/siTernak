<x-guest-layout>
    <div class="min-h-screen flex flex-col items-center justify-center px-6 py-12">
        <div class="w-full max-w-md">
            <a href="/" class="flex items-center gap-2.5 mb-8 justify-center">
                <div class="w-9 h-9 bg-emerald-600 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21V10l9-7 9 7v11H3zM9 21v-6h6v6M3 10l9-4 9 4"/></svg>
                </div>
                <span class="text-xl font-bold text-gray-900">SiTernak</span>
            </a>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-8">
                <h2 class="text-xl font-bold text-gray-900 mb-2">Konfirmasi Password</h2>
                <p class="text-sm text-gray-600 mb-6">Ini adalah area yang dilindungi. Silakan konfirmasi password Anda sebelum melanjutkan.</p>

                <form method="POST" action="{{ route('password.confirm') }}" class="space-y-5">
                    @csrf

                    <div>
                        <x-input-label for="password" value="Password" />
                        <x-text-input id="password" class="block mt-1.5 w-full" type="password" name="password" required autocomplete="current-password" placeholder="Masukkan password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <x-primary-button class="w-full justify-center">
                        Konfirmasi
                    </x-primary-button>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>
