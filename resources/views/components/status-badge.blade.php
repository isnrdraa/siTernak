@props(['status'])

@php
    $classes = match(strtolower($status)) {
        'active', 'aktif' => 'bg-green-100 text-green-700',
        'inactive', 'nonaktif' => 'bg-gray-100 text-gray-700',
        'suspended' => 'bg-red-100 text-red-700',
        'maintenance' => 'bg-yellow-100 text-yellow-700',
        'sold' => 'bg-blue-100 text-blue-700',
        'deceased' => 'bg-red-100 text-red-700',
        'owner' => 'bg-purple-100 text-purple-700',
        'admin' => 'bg-blue-100 text-blue-700',
        'supervisor' => 'bg-amber-100 text-amber-700',
        'staff' => 'bg-gray-100 text-gray-700',
        'vaccination' => 'bg-blue-100 text-blue-700',
        'treatment' => 'bg-amber-100 text-amber-700',
        'checkup' => 'bg-green-100 text-green-700',
        'disease' => 'bg-red-100 text-red-700',
        default => 'bg-gray-100 text-gray-700',
    };

    $label = match(strtolower($status)) {
        'active' => 'Aktif',
        'inactive' => 'Tidak Aktif',
        'suspended' => 'Ditangguhkan',
        'maintenance' => 'Pemeliharaan',
        'sold' => 'Terjual',
        'deceased' => 'Mati',
        'owner' => 'Pemilik',
        'admin' => 'Admin',
        'supervisor' => 'Supervisor',
        'staff' => 'Staf',
        'vaccination' => 'Vaksinasi',
        'treatment' => 'Perawatan',
        'checkup' => 'Pemeriksaan',
        'disease' => 'Penyakit',
        default => ucfirst($status),
    };
@endphp

<span {{ $attributes->merge(['class' => "inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium $classes"]) }}>
    {{ $label }}
</span>
