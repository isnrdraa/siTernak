<x-guest-layout>
    <div class="min-h-screen flex">
        {{-- Branding Panel (Desktop) --}}
        <div class="hidden lg:flex lg:w-1/2 relative bg-gradient-to-br from-emerald-600 to-teal-700 overflow-hidden">
            <div class="absolute top-0 right-0 w-96 h-96 bg-white/5 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 left-0 w-80 h-80 bg-white/5 rounded-full blur-3xl"></div>

            <div class="relative flex flex-col justify-center px-16 text-white">
                <a href="/" class="flex items-center gap-3 mb-12">
                    <div class="w-11 h-11 bg-white/20 backdrop-blur rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21V10l9-7 9 7v11H3zM9 21v-6h6v6M3 10l9-4 9 4"/></svg>
                    </div>
                    <span class="text-2xl font-bold">SiTernak</span>
                </a>

                <h1 class="text-3xl font-bold leading-tight mb-4">Kelola peternakan Anda<br>dari mana saja.</h1>
                <p class="text-emerald-100 text-lg leading-relaxed max-w-md">Platform manajemen peternakan lengkap untuk semua jenis ternak. Pantau kandang, produksi, dan keuangan dalam satu sistem.</p>

                <div class="mt-12 space-y-4">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-white/10 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-emerald-200" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                        </div>
                        <span class="text-sm text-emerald-50">Manajemen kandang real-time</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-white/10 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-emerald-200" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                        </div>
                        <span class="text-sm text-emerald-50">Laporan keuangan otomatis</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-white/10 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-emerald-200" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                        </div>
                        <span class="text-sm text-emerald-50">Multi-pengguna dengan peran akses</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Form Panel --}}
        <div class="w-full lg:w-1/2 flex flex-col justify-center px-6 sm:px-12 lg:px-16 py-12">
            {{-- Mobile Logo --}}
            <div class="lg:hidden flex items-center gap-2.5 mb-10">
                <a href="/" class="flex items-center gap-2.5">
                    <div class="w-9 h-9 bg-emerald-600 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21V10l9-7 9 7v11H3zM9 21v-6h6v6M3 10l9-4 9 4"/></svg>
                    </div>
                    <span class="text-xl font-bold text-gray-900">SiTernak</span>
                </a>
            </div>

            <div class="w-full max-w-md mx-auto lg:mx-0">
                <h2 class="text-2xl font-bold text-gray-900">Masuk ke Akun Anda</h2>
                <p class="mt-2 text-sm text-gray-600">Selamat datang kembali! Masukkan data akun Anda untuk melanjutkan.</p>

                <x-auth-session-status class="mt-4 mb-2" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="mt-8 space-y-5">
                    @csrf

                    <div>
                        <x-input-label for="email" value="Email" />
                        <x-text-input id="email" class="block mt-1.5 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="nama@email.com" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div>
                        <div class="flex items-center justify-between">
                            <x-input-label for="password" value="Password" />
                            @if (Route::has('password.request'))
                                <a class="text-xs font-medium text-emerald-600 hover:text-emerald-700" href="{{ route('password.request') }}">
                                    Lupa password?
                                </a>
                            @endif
                        </div>
                        <x-text-input id="password" class="block mt-1.5 w-full" type="password" name="password" required autocomplete="current-password" placeholder="Masukkan password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <div class="flex items-center">
                        <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-emerald-600 shadow-sm focus:ring-emerald-500" name="remember">
                        <label for="remember_me" class="ms-2 text-sm text-gray-600">Ingat saya</label>
                    </div>

                    <x-primary-button class="w-full justify-center">
                        Masuk
                    </x-primary-button>
                </form>

                <p class="mt-8 text-center text-sm text-gray-600">
                    Belum punya akun?
                    <a href="{{ route('register') }}" class="font-semibold text-emerald-600 hover:text-emerald-700">Daftar gratis</a>
                </p>
            </div>
        </div>
    </div>
</x-guest-layout>
