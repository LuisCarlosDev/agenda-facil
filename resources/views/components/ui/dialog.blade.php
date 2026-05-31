@props([
    'id' => '',
    'title' => '',
])

<div
    data-dialog
    id="{{ $id }}"
    class="fixed inset-0 z-50 hidden"
    role="dialog"
    aria-modal="true"
    @if($title) aria-labelledby="{{ $id }}-title" @endif
>
    <div data-dialog-backdrop class="absolute inset-0 bg-heading/40"></div>

    <div data-dialog-wrapper class="relative flex min-h-full items-center justify-center p-4">
        <div
            data-dialog-panel
            {{ $attributes->merge(['class' => 'relative w-full max-w-sm rounded-xl border border-border bg-surface p-6 shadow-lg']) }}
        >
            <button
                type="button"
                data-dialog-close
                class="absolute right-4 top-4 flex h-8 w-8 items-center justify-center rounded-lg text-muted transition hover:bg-brand-50 hover:text-heading"
                aria-label="Fechar"
            >
                <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                </svg>
            </button>

            @if($title)
                <h2 id="{{ $id }}-title" class="pr-8 text-base font-semibold text-heading">{{ $title }}</h2>
            @endif

            {{ $slot }}
        </div>
    </div>
</div>
