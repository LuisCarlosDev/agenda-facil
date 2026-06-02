<x-layouts.dashboard title="Serviços — AgendaFácil">
    <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-heading">Serviços</h1>
            <p class="mt-1 text-muted">Cadastre os serviços que você oferece para seus clientes agendarem</p>
        </div>

        <button
            type="button"
            data-dialog-open="new-service"
            class="inline-flex h-11 shrink-0 items-center justify-center gap-2 rounded-lg bg-brand-500 px-4 text-sm font-semibold text-white transition hover:bg-brand-600 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-500/40 focus-visible:ring-offset-2"
        >
            <x-ui.icons.plus class="h-4 w-4" />
            Novo Serviço
        </button>
    </div>

    <x-ui.panel data-services-panel class="flex min-h-[420px] flex-col">
        @if ($services->isEmpty())
            <div data-services-empty class="flex flex-1 flex-col items-center justify-center py-16 text-center">
                <p class="text-sm text-muted">Nenhum serviço cadastrado</p>
                <button
                    type="button"
                    data-dialog-open="new-service"
                    class="mt-3 font-semibold text-brand-500 transition hover:text-brand-600"
                >
                    Cadastrar primeiro serviço
                </button>
            </div>
        @else
            <ul data-services-list class="flex flex-col gap-3">
                @foreach ($services as $service)
                    <li
                        data-service-id="{{ $service->id }}"
                        class="flex flex-col gap-3 rounded-lg border border-border px-4 py-4 sm:flex-row sm:items-center sm:justify-between"
                    >
                        <div class="min-w-0 flex-1">
                            <p class="font-semibold text-heading">{{ $service->name }}</p>
                            @if ($service->description)
                                <p class="mt-1 line-clamp-2 text-sm text-muted">{{ $service->description }}</p>
                            @endif
                        </div>
                        <div class="flex shrink-0 items-center gap-3">
                            <span class="inline-flex items-center rounded-full bg-brand-50 px-3 py-1 text-xs font-medium text-brand-600">
                                {{ $service->formattedDuration() }}
                            </span>
                            @if ($service->formattedPrice())
                                <span class="text-sm font-semibold text-heading">{{ $service->formattedPrice() }}</span>
                            @endif
                        </div>
                    </li>
                @endforeach
            </ul>
        @endif
    </x-ui.panel>

    <x-services.create-dialog />
</x-layouts.dashboard>
