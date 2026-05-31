@props([
    'variant' => 'primary',
    'type' => 'button',
])

@php
    $variants = [
        'primary' => 'bg-brand-500 text-white hover:bg-brand-600 focus-visible:ring-brand-500/40',
        'ghost' => 'bg-transparent text-heading hover:bg-brand-50',
        'outline' => 'border border-border bg-surface text-heading hover:bg-brand-50 focus-visible:ring-brand-500/40',
    ];
@endphp

<button
    type="{{ $type }}"
    {{ $attributes->merge([
        'class' => 'inline-flex h-11 items-center justify-center rounded-lg px-4 text-sm font-semibold transition focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 ' . ($variants[$variant] ?? $variants['primary']),
    ]) }}
>
    {{ $slot }}
</button>
