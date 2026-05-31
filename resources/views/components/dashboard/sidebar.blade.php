<aside class="fixed inset-y-0 left-0 z-10 flex w-64 flex-col bg-sidebar px-4 py-6">
    <div class="mb-8 px-2">
        <p class="text-lg font-bold text-white">AgendaFácil</p>
        <p class="text-sm text-sidebar-muted">Dashboard</p>
    </div>

    <nav class="flex flex-col gap-1">
        <x-dashboard.nav-item
            :href="route('dashboard')"
            label="Início"
            :active="request()->routeIs('dashboard')"
        >
            <x-slot:icon>
                <x-ui.icons.home class="h-5 w-5 shrink-0" />
            </x-slot:icon>
        </x-dashboard.nav-item>

        @if (auth()->user()->isProfissional())
            <x-dashboard.nav-item href="#" label="Serviços">
                <x-slot:icon>
                    <x-ui.icons.briefcase class="h-5 w-5 shrink-0" />
                </x-slot:icon>
            </x-dashboard.nav-item>

            <x-dashboard.nav-item href="#" label="Horários">
                <x-slot:icon>
                    <x-ui.icons.clock class="h-5 w-5 shrink-0" />
                </x-slot:icon>
            </x-dashboard.nav-item>
        @endif

        <x-dashboard.nav-item
            :href="route('appointments.index')"
            label="Agendamentos"
            :active="request()->routeIs('appointments.*')"
        >
            <x-slot:icon>
                <x-ui.icons.calendar class="h-5 w-5 shrink-0" />
            </x-slot:icon>
        </x-dashboard.nav-item>
    </nav>
</aside>
