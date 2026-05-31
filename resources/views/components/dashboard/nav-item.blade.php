@props([
    'href' => '#',
    'label' => '',
    'active' => false,
])

@php
    $classes = $active
        ? 'bg-brand-500 text-white'
        : 'text-sidebar-muted hover:bg-white/5 hover:text-white';
@endphp

<a
    href="{{ $href }}"
    {{ $attributes->merge([
        'class' => 'flex items-center gap-3 rounded-lg px-4 py-3 text-sm font-medium transition ' . $classes,
    ]) }}
>
    {{ $icon }}
    {{ $label }}
</a>
