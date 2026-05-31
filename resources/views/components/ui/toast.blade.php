@props([
    'type' => 'success',
    'message' => '',
    'redirect' => null,
])

@php
    $styles = [
        'success' => 'border-emerald-200 bg-emerald-50 text-emerald-800',
        'error' => 'border-red-200 bg-red-50 text-red-800',
    ];
@endphp

<div
    data-toast
    @if($redirect) data-redirect="{{ $redirect }}" @endif
    role="status"
    aria-live="polite"
    {{ $attributes->merge([
        'class' => 'pointer-events-none fixed top-6 left-1/2 z-50 max-w-md -translate-x-1/2 rounded-lg border px-4 py-3 text-sm shadow-lg transition-all duration-300 '.($styles[$type] ?? $styles['success']),
    ]) }}
>
    {{ $message }}
</div>
