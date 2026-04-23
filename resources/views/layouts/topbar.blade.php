<header class="sticky top-0 z-30 flex items-center h-16 px-4 sm:px-6 bg-white border-b border-gray-200">
    {{-- Mobile menu button --}}
    <button @click="sidebarOpen = true" class="lg:hidden text-gray-500 hover:text-gray-700 mr-4">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
    </button>

    {{-- Page Title --}}
    @isset($header)
        <h1 class="text-lg font-semibold text-gray-900">{{ $header }}</h1>
    @endisset

    <div class="flex-1"></div>

    {{-- User Menu --}}
    <div class="flex items-center gap-3">
        <div class="text-right hidden sm:block">
            <p class="text-sm font-medium text-gray-700">{{ Auth::user()->name }}</p>
            @if(isset($currentTenant))
                <p class="text-xs text-gray-500">{{ $currentTenant->name }}</p>
            @endif
        </div>
        <div class="w-8 h-8 rounded-full bg-emerald-100 flex items-center justify-center">
            <span class="text-sm font-medium text-emerald-700">{{ substr(Auth::user()->name, 0, 1) }}</span>
        </div>
    </div>
</header>
