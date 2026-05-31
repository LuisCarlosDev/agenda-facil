@props([
    'tag' => 'div',
])

<{{ $tag }}
    {{ $attributes->merge([
        'class' => 'w-full max-w-md rounded-2xl border border-border bg-surface p-8 shadow-sm',
    ]) }}
>
    {{ $slot }}
</{{ $tag }}>
