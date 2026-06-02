<x-ui.dialog id="new-service" title="Novo Serviço" class="max-w-md">
    <form
        action="{{ route('services.store') }}"
        method="POST"
        data-service-form
        class="mt-5 flex flex-col gap-5 border-t border-border pt-5"
    >
        @csrf

        <x-ui.input
            label="Nome do serviço *"
            name="name"
            placeholder="Ex: Corte de cabelo"
            required
        />

        <x-ui.input
            label="Duração (minutos) *"
            name="duration_minutes"
            type="number"
            min="1"
            step="1"
            placeholder="Ex: 30"
            required
        />

        <x-ui.input
            label="Descrição"
            name="description"
            placeholder="Opcional"
        />

        <x-ui.input
            label="Preço (R$)"
            name="price"
            type="number"
            min="0"
            step="0.01"
            placeholder="Opcional"
        />

        <div class="flex items-center justify-between gap-3 pt-1">
            <x-ui.button type="button" variant="outline" data-dialog-close>
                Cancelar
            </x-ui.button>

            <x-ui.button type="submit">
                Salvar
            </x-ui.button>
        </div>
    </form>
</x-ui.dialog>
