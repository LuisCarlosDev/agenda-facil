@props([
    'services' => [],
])

<x-ui.dialog id="new-appointment" title="Novo Agendamento" class="max-w-md">
    <form action="#" method="POST" class="mt-5 flex flex-col gap-5 border-t border-border pt-5">
        @csrf

        <x-ui.select
            label="Serviço *"
            name="service_id"
            :options="array_merge(['' => 'Selecione um serviço'], $services)"
            required
        />

        <x-ui.input
            label="Data *"
            name="date"
            type="date"
            required
        />

        <x-ui.input
            label="Hora *"
            name="time"
            type="time"
            required
        />

        <div class="flex items-center justify-between gap-3 pt-1">
            <x-ui.button type="button" variant="outline" data-dialog-close>
                Cancelar
            </x-ui.button>

            <x-ui.button type="submit">
                Agendar
            </x-ui.button>
        </div>
    </form>
</x-ui.dialog>
