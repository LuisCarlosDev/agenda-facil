@props([
    'tag' => 'div',
])

<{{ $tag }}
    {{ $attributes->merge([
        'class' => 'rounded-xl border border-border bg-surface p-6 shadow-sm',
    ]) }}
>
    {{ $slot }}
</{{ $tag }}>
