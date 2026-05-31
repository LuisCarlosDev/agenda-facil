@props([
    'label' => null,
    'name' => '',
    'id' => null,
    'options' => [],
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

    <select
        name="{{ $name }}"
        id="{{ $inputId }}"
        @if($required) required @endif
        {{ $attributes->except('class')->merge([
            'class' => 'h-11 w-full appearance-none rounded-lg border border-border bg-surface px-3.5 text-sm text-heading outline-none transition focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20',
        ]) }}
    >
        @foreach($options as $optionValue => $optionLabel)
            <option value="{{ $optionValue }}" @selected(old($name, $value) === (string) $optionValue)>
                {{ $optionLabel }}
            </option>
        @endforeach
    </select>
</div>
