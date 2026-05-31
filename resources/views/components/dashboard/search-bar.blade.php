<div {{ $attributes->merge(['class' => 'relative w-full max-w-xl']) }}>
    <x-ui.icons.search class="pointer-events-none absolute left-3.5 top-1/2 h-5 w-5 -translate-y-1/2 text-muted" />

    <input
        type="search"
        placeholder="Buscar..."
        {{ $attributes->except('class')->merge([
            'class' => 'h-11 w-full rounded-lg border border-border bg-surface py-2 pl-11 pr-4 text-sm text-heading placeholder:text-placeholder outline-none transition focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20',
        ]) }}
    />
</div>
