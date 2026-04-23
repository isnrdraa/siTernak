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

                <h1 class="text-3xl font-bold leading-tight mb-4">Mulai kelola peternakan<br>Anda hari ini.</h1>
                <p class="text-emerald-100 text-lg leading-relaxed max-w-md">Daftarkan usaha peternakan Anda dan nikmati semua fitur manajemen lengkap secara gratis.</p>

                <div class="mt-12 space-y-5">
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 bg-white/10 rounded-xl flex items-center justify-center flex-shrink-0 mt-0.5">
                            <svg class="w-5 h-5 text-emerald-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21V10l9-7 9 7v11H3zM9 21v-6h6v6M3 10l9-4 9 4"/></svg>
                        </div>
                        <div>
                            <p class="font-semibold text-sm">Manajemen Kandang</p>
                            <p class="text-emerald-100 text-sm mt-0.5">Monitor kapasitas, isi, dan riwayat pergerakan ternak.</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 bg-white/10 rounded-xl flex items-center justify-center flex-shrink-0 mt-0.5">
                            <svg class="w-5 h-5 text-emerald-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div>
                            <p class="font-semibold text-sm">Keuangan & Penjualan</p>
                            <p class="text-emerald-100 text-sm mt-0.5">Jual produk/hewan, catat pengeluaran, dan lihat laba rugi.</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 bg-white/10 rounded-xl flex items-center justify-center flex-shrink-0 mt-0.5">
                            <svg class="w-5 h-5 text-emerald-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                        </div>
                        <div>
                            <p class="font-semibold text-sm">Laporan & Analitik</p>
                            <p class="text-emerald-100 text-sm mt-0.5">Grafik tren produksi, pakan, dan keuangan lengkap.</p>
                        </div>
                    </div>
                </div>

                <div class="mt-12 pt-8 border-t border-white/10">
                    <p class="text-emerald-200 text-sm font-medium">100% Gratis &middot; Tanpa Kartu Kredit &middot; Langsung Pakai</p>
                </div>
            </div>
        </div>

        {{-- Form Panel --}}
        <div class="w-full lg:w-1/2 flex flex-col justify-center px-6 sm:px-12 lg:px-16 py-12">
            {{-- Mobile Logo --}}
            <div class="lg:hidden flex items-center gap-2.5 mb-8">
                <a href="/" class="flex items-center gap-2.5">
                    <div class="w-9 h-9 bg-emerald-600 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21V10l9-7 9 7v11H3zM9 21v-6h6v6M3 10l9-4 9 4"/></svg>
                    </div>
                    <span class="text-xl font-bold text-gray-900">SiTernak</span>
                </a>
            </div>

            <div class="w-full max-w-md mx-auto lg:mx-0">
                <h2 class="text-2xl font-bold text-gray-900">Daftarkan Usaha Anda</h2>
                <p class="mt-2 text-sm text-gray-600">Buat akun pemilik usaha peternakan untuk mulai mengelola peternakan Anda.</p>

                <form method="POST" action="{{ route('register') }}" class="mt-8 space-y-5">
                    @csrf

                    <div>
                        <x-input-label for="tenant_name" value="Nama Usaha / Peternakan" />
                        <x-text-input id="tenant_name" class="block mt-1.5 w-full" type="text" name="tenant_name" :value="old('tenant_name')" required autofocus placeholder="cth: Peternakan Sejahtera" />
                        <x-input-error :messages="$errors->get('tenant_name')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="name" value="Nama Lengkap" />
                        <x-text-input id="name" class="block mt-1.5 w-full" type="text" name="name" :value="old('name')" required autocomplete="name" placeholder="Nama lengkap Anda" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="email" value="Email" />
                        <x-text-input id="email" class="block mt-1.5 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="nama@email.com" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <x-input-label for="password" value="Password" />
                            <x-text-input id="password" class="block mt-1.5 w-full" type="password" name="password" required autocomplete="new-password" placeholder="Min. 8 karakter" />
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="password_confirmation" value="Konfirmasi Password" />
                            <x-text-input id="password_confirmation" class="block mt-1.5 w-full" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Ulangi password" />
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                        </div>
                    </div>

                    <x-primary-button class="w-full justify-center">
                        Daftar Gratis
                    </x-primary-button>
                </form>

                <p class="mt-8 text-center text-sm text-gray-600">
                    Sudah punya akun?
                    <a href="{{ route('login') }}" class="font-semibold text-emerald-600 hover:text-emerald-700">Masuk di sini</a>
                </p>
            </div>
        </div>
    </div>
</x-guest-layout>
