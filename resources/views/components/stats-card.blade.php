@props(['title', 'value', 'icon' => null, 'color' => 'emerald'])

@php
    $colorClasses = [
        'emerald' => 'bg-emerald-50 text-emerald-600',
        'blue' => 'bg-blue-50 text-blue-600',
        'amber' => 'bg-amber-50 text-amber-600',
        'red' => 'bg-red-50 text-red-600',
        'purple' => 'bg-purple-50 text-purple-600',
        'gray' => 'bg-gray-50 text-gray-600',
    ];
    $iconColor = $colorClasses[$color] ?? $colorClasses['emerald'];
@endphp

<div class="bg-white rounded-xl border border-gray-200 p-5">
    <div class="flex items-center justify-between">
        <div>
            <p class="text-sm font-medium text-gray-500">{{ $title }}</p>
            <p class="mt-1 text-2xl font-bold text-gray-900">{{ $value }}</p>
        </div>
        @if($icon)
            <div class="w-10 h-10 rounded-lg {{ $iconColor }} flex items-center justify-center">
                {!! $icon !!}
            </div>
        @endif
    </div>
    @if($slot->isNotEmpty())
        <div class="mt-3 text-sm text-gray-500">
            {{ $slot }}
        </div>
    @endif
</div>
