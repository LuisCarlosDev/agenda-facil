<x-layouts.dashboard title="Dashboard — AgendaFácil">
    <x-dashboard.welcome-header :name="auth()->user()->name" />

    <div class="mb-6 grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
        <x-dashboard.stat-card
            label="Total de Serviços"
            :value="$stats['totalServices']"
            theme="blue"
        >
            <x-slot:icon>
                <x-ui.icons.briefcase class="h-6 w-6" />
            </x-slot:icon>
        </x-dashboard.stat-card>

        <x-dashboard.stat-card
            label="Pendentes"
            :value="$stats['pending']"
            theme="yellow"
        >
            <x-slot:icon>
                <x-ui.icons.clock class="h-6 w-6" />
            </x-slot:icon>
        </x-dashboard.stat-card>

        <x-dashboard.stat-card
            label="Confirmados"
            :value="$stats['confirmed']"
            theme="green"
        >
            <x-slot:icon>
                <x-ui.icons.calendar class="h-6 w-6" />
            </x-slot:icon>
        </x-dashboard.stat-card>

        <x-dashboard.stat-card
            label="Concluídos"
            :value="$stats['completed']"
            theme="purple"
        >
            <x-slot:icon>
                <x-ui.icons.check-circle class="h-6 w-6" />
            </x-slot:icon>
        </x-dashboard.stat-card>
    </div>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
        <x-dashboard.chart-card
            class="lg:col-span-2"
            :pending="$stats['pending']"
            :confirmed="$stats['confirmed']"
            :completed="$stats['completed']"
        />

        <x-dashboard.activity-card :activities="$activities" />
    </div>
</x-layouts.dashboard>
