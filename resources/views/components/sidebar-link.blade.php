@props(['active' => false])

<a {{ $attributes->merge([
    'class' => 'flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-lg transition-colors ' .
        ($active
            ? 'bg-emerald-50 text-emerald-700'
            : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900')
]) }}>
    {{ $slot }}
</a>
