@php
    $pageTitle = auth()->user()->isCliente() ? 'Meus Agendamentos' : 'Agendamentos';
@endphp

<x-layouts.dashboard :title="$pageTitle . ' — AgendaFácil'">
    <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-heading">{{ auth()->user()->isCliente() ? 'Meus Agendamentos' : 'Agendamentos' }}</h1>
            <p class="mt-1 text-muted">Gerencie seus agendamentos</p>
        </div>

        <button
            type="button"
            data-dialog-open="new-appointment"
            class="inline-flex h-11 shrink-0 items-center justify-center gap-2 rounded-lg bg-brand-500 px-4 text-sm font-semibold text-white transition hover:bg-brand-600 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-500/40 focus-visible:ring-offset-2"
        >
            <x-ui.icons.plus class="h-4 w-4" />
            Novo Agendamento
        </button>
    </div>

    <x-ui.panel class="flex min-h-[420px] flex-col">
        @if ($appointments->isEmpty())
            <div class="flex flex-1 flex-col items-center justify-center py-16 text-center">
                <p class="text-sm text-muted">Nenhum agendamento encontrado</p>
                <button
                    type="button"
                    data-dialog-open="new-appointment"
                    class="mt-3 font-semibold text-brand-500 transition hover:text-brand-600"
                >
                    Criar primeiro agendamento
                </button>
            </div>
        @else
            <ul class="flex flex-col gap-3">
                @foreach ($appointments as $appointment)
                    <li class="text-sm text-heading">{{ $appointment }}</li>
                @endforeach
            </ul>
        @endif
    </x-ui.panel>

    <x-appointments.create-dialog />
</x-layouts.dashboard>
