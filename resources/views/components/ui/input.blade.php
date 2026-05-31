@props([
    'label' => null,
    'name' => '',
    'id' => null,
    'type' => 'text',
    'placeholder' => '',
    'value' => '',
    'required' => false,
])

@php
    $inputId = $id ?? $name;
@endphp

<div {{ $attributes->only('class')->merge(['class' => 'flex flex-col gap-2']) }}>
    @if($label)
        <x-ui.label :for="$inputId">{{ $label }}</x-ui.label>
    @endif

    <input
        type="{{ $type }}"
        name="{{ $name }}"
        id="{{ $inputId }}"
        value="{{ old($name, $value) }}"
        placeholder="{{ $placeholder }}"
        @if($required) required @endif
        {{ $attributes->except('class')->merge([
            'class' => 'h-11 w-full rounded-lg border border-border bg-surface px-3.5 text-sm text-heading placeholder:text-placeholder outline-none transition focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20',
        ]) }}
    />
</div>
