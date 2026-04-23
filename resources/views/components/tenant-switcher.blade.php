@props(['currentTenant'])

@php
    $tenants = auth()->user()->tenants;
@endphp

<div x-data="{ open: false }" class="px-3 py-3 border-b border-gray-200">
    <button @click="open = !open" class="flex items-center justify-between w-full px-3 py-2 text-sm font-medium text-gray-700 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
        <div class="flex items-center gap-2 min-w-0">
            <div class="w-6 h-6 bg-emerald-100 rounded flex items-center justify-center shrink-0">
                <span class="text-xs font-bold text-emerald-700">{{ substr($currentTenant->name, 0, 1) }}</span>
            </div>
            <span class="truncate">{{ $currentTenant->name }}</span>
        </div>
        @if($tenants->count() > 1)
            <svg class="w-4 h-4 shrink-0 text-gray-400 transition-transform" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
        @endif
    </button>

    @if($tenants->count() > 1)
        <div x-show="open" x-transition @click.away="open = false" class="mt-2 space-y-1">
            @foreach($tenants as $tenant)
                @if($tenant->id !== $currentTenant->id)
                    <form method="POST" action="{{ route('tenant.switch') }}">
                        @csrf
                        <input type="hidden" name="tenant_id" value="{{ $tenant->id }}">
                        <button type="submit" class="flex items-center gap-2 w-full px-3 py-2 text-sm text-gray-600 rounded-lg hover:bg-gray-50 transition-colors">
                            <div class="w-6 h-6 bg-gray-100 rounded flex items-center justify-center shrink-0">
                                <span class="text-xs font-bold text-gray-500">{{ substr($tenant->name, 0, 1) }}</span>
                            </div>
                            <span class="truncate">{{ $tenant->name }}</span>
                        </button>
                    </form>
                @endif
            @endforeach

            <a href="{{ route('tenant.create') }}" class="flex items-center gap-2 w-full px-3 py-2 text-sm text-emerald-600 rounded-lg hover:bg-emerald-50 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                Buat Usaha Baru
            </a>
        </div>
    @endif
</div>
