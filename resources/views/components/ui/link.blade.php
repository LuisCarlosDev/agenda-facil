<a
    {{ $attributes->merge([
        'class' => 'font-semibold text-brand-500 transition hover:text-brand-600',
    ]) }}
>
    {{ $slot }}
</a>
