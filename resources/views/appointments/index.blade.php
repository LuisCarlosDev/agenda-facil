@php
    $pageTitle = auth()->user()->isCliente() ? 'Meus Agendamentos' : 'Agendamentos';
@endphp

<x-layouts.dashboard :title="$pageTitle . ' — AgendaFácil'">
    <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-heading">{{ $pageTitle }}</h1>
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
                    <li class="flex flex-col gap-2 rounded-lg border border-border px-4 py-4 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <p class="font-semibold text-heading">{{ $appointment->service->name }}</p>
                            <p class="mt-1 text-sm text-muted">
                                {{ $appointment->starts_at->format('d/m/Y') }} às {{ $appointment->starts_at->format('H:i') }}
                                · {{ $appointment->service->formattedDuration() }}
                            </p>
                            <p class="mt-0.5 text-sm text-muted">
                                @if (auth()->user()->isCliente())
                                    com {{ $appointment->professional->name }}
                                @else
                                    {{ $appointment->client->name }}
                                @endif
                            </p>
                        </div>
                        @php
                            $statusLabels = [
                                'pending' => 'Pendente',
                                'confirmed' => 'Confirmado',
                                'completed' => 'Concluído',
                                'cancelled' => 'Cancelado',
                            ];
                        @endphp
                        <span class="inline-flex w-fit rounded-full bg-brand-50 px-3 py-1 text-xs font-medium text-brand-600">
                            {{ $statusLabels[$appointment->status] ?? $appointment->status }}
                        </span>
                    </li>
                @endforeach
            </ul>
        @endif
    </x-ui.panel>

    @if (auth()->user()->isCliente())
        <x-appointments.book-dialog
            :professionals="$professionals"
            :professional-services="$professionalServices"
        />
    @else
        <x-appointments.create-dialog />
    @endif
</x-layouts.dashboard>
