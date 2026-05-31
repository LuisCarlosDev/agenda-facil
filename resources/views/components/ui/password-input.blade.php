@props([
    'label' => 'Senha',
    'name' => 'password',
    'id' => null,
    'placeholder' => '',
    'value' => '',
    'required' => true,
])

@php
    $inputId = $id ?? $name;
@endphp

<div {{ $attributes->only('class')->merge(['class' => 'flex flex-col gap-2']) }} data-password-field>
    <x-ui.label :for="$inputId">{{ $label }}</x-ui.label>

    <div class="relative">
        <input
            type="password"
            name="{{ $name }}"
            id="{{ $inputId }}"
            value="{{ old($name, $value) }}"
            placeholder="{{ $placeholder }}"
            @if($required) required @endif
            {{ $attributes->except('class')->merge([
                'class' => 'h-11 w-full rounded-lg border border-border bg-surface py-2 pl-3.5 pr-11 text-sm text-heading placeholder:text-placeholder outline-none transition focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20',
            ]) }}
        />

        <button
            type="button"
            data-password-toggle
            aria-label="Mostrar senha"
            class="absolute inset-y-0 right-0 flex items-center px-3 text-muted transition hover:text-heading"
        >
            <span data-icon-show>
                <x-ui.icons.eye />
            </span>
            <span data-icon-hide class="hidden">
                <x-ui.icons.eye-slash />
            </span>
        </button>
    </div>
</div>
