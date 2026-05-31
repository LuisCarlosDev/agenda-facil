@props([
    'activities' => [],
    'viewAllUrl' => '#',
])

<x-ui.panel {{ $attributes->merge(['class' => 'flex flex-col']) }}>
    <x-ui.panel-header>Atividades Recentes</x-ui.panel-header>

    <div class="flex flex-1 flex-col">
        @if (count($activities) === 0)
            <p class="flex flex-1 items-center justify-center py-8 text-sm text-muted">Nenhuma atividade recente</p>
        @else
            <ul class="flex flex-1 flex-col gap-3">
                @foreach ($activities as $activity)
                    <li class="text-sm text-heading">{{ $activity }}</li>
                @endforeach
            </ul>
        @endif

        <a
            href="{{ $viewAllUrl }}"
            class="mt-6 inline-flex h-11 w-full items-center justify-center rounded-lg border border-border bg-surface px-4 text-sm font-semibold text-heading transition hover:bg-brand-50"
        >
            Ver Todos
        </a>
    </div>
</x-ui.panel>
