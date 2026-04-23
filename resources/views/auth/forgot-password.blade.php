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
                <h2 class="text-xl font-bold text-gray-900 mb-2">Lupa Password</h2>
                <p class="text-sm text-gray-600 mb-6">Masukkan email Anda dan kami akan mengirimkan tautan untuk mengatur ulang password.</p>

                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
                    @csrf

                    <div>
                        <x-input-label for="email" value="Email" />
                        <x-text-input id="email" class="block mt-1.5 w-full" type="email" name="email" :value="old('email')" required autofocus placeholder="nama@email.com" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <x-primary-button class="w-full justify-center">
                        Kirim Tautan Reset Password
                    </x-primary-button>
                </form>
            </div>

            <p class="mt-6 text-center text-sm text-gray-600">
                <a href="{{ route('login') }}" class="font-semibold text-emerald-600 hover:text-emerald-700">Kembali ke halaman masuk</a>
            </p>
        </div>
    </div>
</x-guest-layout>
