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
                <h2 class="text-xl font-bold text-gray-900 mb-2">Verifikasi Email</h2>
                <p class="text-sm text-gray-600 mb-6">Terima kasih telah mendaftar! Sebelum melanjutkan, silakan verifikasi alamat email Anda dengan mengklik tautan yang baru saja kami kirimkan. Jika tidak menerima email, kami akan mengirimkan ulang.</p>

                @if (session('status') == 'verification-link-sent')
                    <div class="mb-4 p-3 bg-emerald-50 border border-emerald-200 rounded-lg">
                        <p class="text-sm font-medium text-emerald-700">Tautan verifikasi baru telah dikirim ke alamat email Anda.</p>
                    </div>
                @endif

                <div class="flex items-center justify-between">
                    <form method="POST" action="{{ route('verification.send') }}">
                        @csrf
                        <x-primary-button>
                            Kirim Ulang Email
                        </x-primary-button>
                    </form>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-sm font-medium text-gray-600 hover:text-gray-900 transition-colors">
                            Keluar
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
