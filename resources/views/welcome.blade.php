<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SiTernak - Kelola Peternakan Lebih Mudah</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-white text-gray-900">

    {{-- Navbar --}}
    <nav class="fixed top-0 inset-x-0 z-50 bg-white/80 backdrop-blur-lg border-b border-gray-100">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <a href="/" class="flex items-center gap-2.5">
                    <div class="w-9 h-9 bg-emerald-600 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21V10l9-7 9 7v11H3zM9 21v-6h6v6M3 10l9-4 9 4"/></svg>
                    </div>
                    <span class="text-xl font-bold text-gray-900">SiTernak</span>
                </a>
                <div class="flex items-center gap-3">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="px-5 py-2 text-sm font-medium text-white bg-emerald-600 rounded-lg hover:bg-emerald-700 transition-colors">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="px-4 py-2 text-sm font-medium text-gray-700 hover:text-gray-900 transition-colors">Masuk</a>
                        <a href="{{ route('register') }}" class="px-5 py-2 text-sm font-medium text-white bg-emerald-600 rounded-lg hover:bg-emerald-700 transition-colors">Daftar Gratis</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    {{-- Hero --}}
    <section class="relative pt-32 pb-20 sm:pt-40 sm:pb-28 overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-emerald-50 via-white to-teal-50"></div>
        <div class="absolute top-20 right-0 w-96 h-96 bg-emerald-200/30 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-0 w-80 h-80 bg-teal-200/20 rounded-full blur-3xl"></div>

        <div class="relative max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="inline-flex items-center gap-2 px-4 py-1.5 bg-emerald-100 text-emerald-700 rounded-full text-sm font-medium mb-6">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                Gratis untuk semua peternak
            </div>
            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight text-gray-900 leading-tight">
                Kelola Peternakan Anda<br>
                <span class="text-emerald-600">Lebih Mudah & Terorganisir</span>
            </h1>
            <p class="mt-6 text-lg sm:text-xl text-gray-600 max-w-2xl mx-auto leading-relaxed">
                Aplikasi manajemen peternakan lengkap untuk semua jenis ternak. Pantau kandang, produksi, keuangan, dan kesehatan hewan dalam satu platform.
            </p>
            <div class="mt-10 flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="{{ route('register') }}" class="w-full sm:w-auto px-8 py-3.5 text-base font-semibold text-white bg-emerald-600 rounded-xl hover:bg-emerald-700 shadow-lg shadow-emerald-200 transition-all hover:shadow-xl hover:shadow-emerald-200">
                    Mulai Gratis Sekarang
                </a>
                <a href="#fitur" class="w-full sm:w-auto px-8 py-3.5 text-base font-semibold text-gray-700 bg-white border border-gray-200 rounded-xl hover:border-gray-300 hover:bg-gray-50 transition-colors">
                    Lihat Fitur
                </a>
            </div>
            <p class="mt-4 text-sm text-gray-400">Tanpa kartu kredit. Langsung pakai.</p>
        </div>
    </section>

    {{-- Stats --}}
    <section class="py-12 bg-white border-y border-gray-100">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-8 text-center">
                <div>
                    <p class="text-3xl font-bold text-emerald-600">100%</p>
                    <p class="mt-1 text-sm text-gray-500">Gratis Digunakan</p>
                </div>
                <div>
                    <p class="text-3xl font-bold text-emerald-600">Multi</p>
                    <p class="mt-1 text-sm text-gray-500">Jenis Ternak</p>
                </div>
                <div>
                    <p class="text-3xl font-bold text-emerald-600">Real-time</p>
                    <p class="mt-1 text-sm text-gray-500">Data & Laporan</p>
                </div>
                <div>
                    <p class="text-3xl font-bold text-emerald-600">Tim</p>
                    <p class="mt-1 text-sm text-gray-500">Multi-pengguna</p>
                </div>
            </div>
        </div>
    </section>

    {{-- Fitur --}}
    <section id="fitur" class="py-20 sm:py-28 bg-gray-50">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl sm:text-4xl font-bold text-gray-900">Semua yang Anda Butuhkan</h2>
                <p class="mt-4 text-lg text-gray-600 max-w-2xl mx-auto">Fitur lengkap untuk mengelola peternakan dari hulu ke hilir, apapun jenis ternaknya.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                {{-- Fitur 1 --}}
                <div class="bg-white rounded-2xl p-7 border border-gray-200 hover:border-emerald-200 hover:shadow-lg hover:shadow-emerald-50 transition-all group">
                    <div class="w-12 h-12 bg-emerald-100 text-emerald-600 rounded-xl flex items-center justify-center mb-5 group-hover:bg-emerald-600 group-hover:text-white transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21V10l9-7 9 7v11H3zM9 21v-6h6v6M3 10l9-4 9 4"/></svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Manajemen Kandang</h3>
                    <p class="text-sm text-gray-600 leading-relaxed">Monitor kapasitas dan isi setiap kandang secara real-time. Tambah dan kurangi stok ternak dengan riwayat pergerakan lengkap.</p>
                </div>

                {{-- Fitur 2 --}}
                <div class="bg-white rounded-2xl p-7 border border-gray-200 hover:border-emerald-200 hover:shadow-lg hover:shadow-emerald-50 transition-all group">
                    <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-xl flex items-center justify-center mb-5 group-hover:bg-blue-600 group-hover:text-white transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Produksi Harian</h3>
                    <p class="text-sm text-gray-600 leading-relaxed">Catat produksi multi-produk setiap hari. Telur, susu, madu, atau apapun hasil ternak Anda -- semua tercatat rapi dengan validasi.</p>
                </div>

                {{-- Fitur 3 --}}
                <div class="bg-white rounded-2xl p-7 border border-gray-200 hover:border-emerald-200 hover:shadow-lg hover:shadow-emerald-50 transition-all group">
                    <div class="w-12 h-12 bg-amber-100 text-amber-600 rounded-xl flex items-center justify-center mb-5 group-hover:bg-amber-600 group-hover:text-white transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Keuangan & Penjualan</h3>
                    <p class="text-sm text-gray-600 leading-relaxed">Jual produk dan hewan ternak, catat pengeluaran, dan lihat laba/rugi secara otomatis. Semua transaksi terlacak.</p>
                </div>

                {{-- Fitur 4 --}}
                <div class="bg-white rounded-2xl p-7 border border-gray-200 hover:border-emerald-200 hover:shadow-lg hover:shadow-emerald-50 transition-all group">
                    <div class="w-12 h-12 bg-orange-100 text-orange-600 rounded-xl flex items-center justify-center mb-5 group-hover:bg-orange-600 group-hover:text-white transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Stok Pakan</h3>
                    <p class="text-sm text-gray-600 leading-relaxed">Kelola inventaris pakan dengan running balance. Dapatkan peringatan otomatis saat stok menipis dan lacak semua pembelian.</p>
                </div>

                {{-- Fitur 5 --}}
                <div class="bg-white rounded-2xl p-7 border border-gray-200 hover:border-emerald-200 hover:shadow-lg hover:shadow-emerald-50 transition-all group">
                    <div class="w-12 h-12 bg-red-100 text-red-600 rounded-xl flex items-center justify-center mb-5 group-hover:bg-red-600 group-hover:text-white transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Kesehatan & Kematian</h3>
                    <p class="text-sm text-gray-600 leading-relaxed">Catat vaksinasi, perawatan, penyakit, dan kematian. Stok kandang otomatis berkurang dan semua tercatat di riwayat.</p>
                </div>

                {{-- Fitur 6 --}}
                <div class="bg-white rounded-2xl p-7 border border-gray-200 hover:border-emerald-200 hover:shadow-lg hover:shadow-emerald-50 transition-all group">
                    <div class="w-12 h-12 bg-purple-100 text-purple-600 rounded-xl flex items-center justify-center mb-5 group-hover:bg-purple-600 group-hover:text-white transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Laporan & Analitik</h3>
                    <p class="text-sm text-gray-600 leading-relaxed">Grafik tren produksi, konsumsi pakan, kematian, dan keuangan. Data yang membantu Anda mengambil keputusan tepat.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- Untuk Siapa --}}
    <section class="py-20 sm:py-28 bg-white">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl sm:text-4xl font-bold text-gray-900">Untuk Semua Jenis Peternakan</h2>
                <p class="mt-4 text-lg text-gray-600">SiTernak dirancang fleksibel untuk berbagai jenis usaha peternakan.</p>
            </div>
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4">
                @foreach(['Ayam Petelur', 'Ayam Pedaging', 'Sapi Perah', 'Kambing/Domba', 'Ikan/Lele'] as $jenis)
                    <div class="bg-gray-50 rounded-xl p-5 text-center border border-gray-100 hover:border-emerald-200 transition-colors">
                        <p class="text-sm font-semibold text-gray-800">{{ $jenis }}</p>
                    </div>
                @endforeach
            </div>
            <p class="text-center mt-6 text-sm text-gray-500">Dan masih banyak lagi -- produk dan satuan bisa disesuaikan sepenuhnya.</p>
        </div>
    </section>

    {{-- CTA --}}
    <section class="py-20 sm:py-28 relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-emerald-600 to-teal-700"></div>
        <div class="absolute top-0 right-0 w-96 h-96 bg-white/5 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-0 w-80 h-80 bg-white/5 rounded-full blur-3xl"></div>

        <div class="relative max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl sm:text-4xl font-bold text-white">Siap Mengelola Peternakan Lebih Baik?</h2>
            <p class="mt-4 text-lg text-emerald-100 max-w-xl mx-auto">Daftarkan usaha peternakan Anda sekarang. Gratis, tanpa batas waktu, tanpa kartu kredit.</p>
            <div class="mt-10">
                <a href="{{ route('register') }}" class="inline-flex items-center px-8 py-4 text-base font-semibold text-emerald-700 bg-white rounded-xl hover:bg-emerald-50 shadow-xl transition-all">
                    Daftar Gratis Sekarang
                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                </a>
            </div>
        </div>
    </section>

    {{-- Footer --}}
    <footer class="py-8 bg-gray-900">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="flex items-center gap-2">
                    <div class="w-7 h-7 bg-emerald-600 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21V10l9-7 9 7v11H3zM9 21v-6h6v6M3 10l9-4 9 4"/></svg>
                    </div>
                    <span class="text-sm font-semibold text-white">SiTernak</span>
                </div>
                <p class="text-sm text-gray-400">&copy; {{ date('Y') }} SiTernak. Hak cipta dilindungi.</p>
            </div>
        </div>
    </footer>

</body>
</html>
