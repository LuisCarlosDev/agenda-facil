@props([
    'professionals' => collect(),
    'professionalServices' => [],
])

<x-ui.dialog id="new-appointment" title="Novo Agendamento" class="max-w-md">
    <form
        data-booking-dialog-form
        action="{{ route('appointments.store') }}"
        data-professional-services='@json($professionalServices)'
        class="mt-5 flex flex-col gap-5 border-t border-border pt-5"
    >
        @csrf

        <x-ui.select
            label="Profissional *"
            name="professional_id"
            data-booking-professional
            :options="array_merge(['' => 'Selecione um profissional'], $professionals->pluck('name', 'id')->all())"
            required
        />

        <div class="flex flex-col gap-2">
            <x-ui.label for="booking_service_id">Serviço *</x-ui.label>
            <select
                id="booking_service_id"
                name="service_id"
                data-booking-service
                required
                disabled
                class="h-11 w-full appearance-none rounded-lg border border-border bg-surface px-3.5 text-sm text-heading outline-none transition focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 disabled:cursor-not-allowed disabled:opacity-60"
            >
                <option value="">Selecione um profissional</option>
            </select>
            <p data-booking-services-empty class="hidden text-sm text-muted">
                Este profissional ainda não possui serviços disponíveis.
            </p>
        </div>

        @foreach ($professionals as $professional)
            <template data-booking-services-for="{{ $professional->id }}">
                @foreach ($professional->services as $service)
                    <option value="{{ $service->id }}" data-name="{{ $service->name }}">
                        {{ $service->name }} ({{ $service->formattedDuration() }})
                    </option>
                @endforeach
            </template>
        @endforeach

        <x-ui.input
            label="Data *"
            name="date"
            type="date"
            :value="now()->format('Y-m-d')"
            min="{{ now()->format('Y-m-d') }}"
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
