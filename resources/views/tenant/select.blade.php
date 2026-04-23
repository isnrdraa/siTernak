<x-guest-layout>
    <div class="text-center mb-6">
        <h2 class="text-xl font-bold text-gray-900">Pilih Usaha</h2>
        <p class="mt-1 text-sm text-gray-500">Pilih usaha yang ingin Anda kelola</p>
    </div>

    <div class="space-y-3">
        @foreach($tenants as $tenant)
            <form method="POST" action="{{ route('tenant.switch') }}">
                @csrf
                <input type="hidden" name="tenant_id" value="{{ $tenant->id }}">
                <button type="submit" class="w-full flex items-center gap-4 p-4 rounded-lg border border-gray-200 hover:border-emerald-300 hover:bg-emerald-50 transition-colors text-left">
                    <div class="w-10 h-10 bg-emerald-100 rounded-lg flex items-center justify-center shrink-0">
                        <span class="text-lg font-bold text-emerald-700">{{ substr($tenant->name, 0, 1) }}</span>
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="text-sm font-semibold text-gray-900 truncate">{{ $tenant->name }}</p>
                        <p class="text-xs text-gray-500">{{ $tenant->users_count }} anggota &middot; {{ $tenant->cages_count }} kandang</p>
                    </div>
                    <svg class="w-5 h-5 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </button>
            </form>
        @endforeach
    </div>

    <div class="mt-6 text-center">
        <a href="{{ route('tenant.create') }}" class="inline-flex items-center gap-1 text-sm text-emerald-600 hover:text-emerald-700 font-medium">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
            Buat Usaha Baru
        </a>
    </div>
</x-guest-layout>
