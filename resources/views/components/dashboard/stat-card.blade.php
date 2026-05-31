@props([
    'label' => '',
    'value' => 0,
    'theme' => 'blue',
])

@php
    $themes = [
        'blue' => [
            'icon' => 'bg-blue-50 text-blue-500',
        ],
        'yellow' => [
            'icon' => 'bg-amber-50 text-amber-500',
        ],
        'green' => [
            'icon' => 'bg-emerald-50 text-emerald-500',
        ],
        'purple' => [
            'icon' => 'bg-purple-50 text-purple-500',
        ],
    ];

    $themeClasses = $themes[$theme] ?? $themes['blue'];
@endphp

<x-ui.panel {{ $attributes }}>
    <div class="flex items-center justify-between gap-4">
        <div>
            <p class="text-sm text-muted">{{ $label }}</p>
            <p class="mt-1 text-3xl font-bold text-heading">{{ $value }}</p>
        </div>

        <div class="flex h-12 w-12 items-center justify-center rounded-full {{ $themeClasses['icon'] }}">
            {{ $icon }}
        </div>
    </div>
</x-ui.panel>
