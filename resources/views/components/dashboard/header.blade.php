@php
    $user = auth()->user();
    $roleLabels = [
        'profissional' => 'Profissional',
        'cliente' => 'Cliente',
    ];
@endphp

<header class="flex items-center justify-between gap-4 border-b border-border bg-surface px-6 py-4">
    <x-dashboard.search-bar />

    <div class="flex items-center gap-4">
        <button
            type="button"
            class="relative flex h-10 w-10 items-center justify-center rounded-lg text-muted transition hover:bg-brand-50 hover:text-heading"
            aria-label="Notificações"
        >
            <x-ui.icons.bell class="h-5 w-5" />
            <span class="absolute right-2 top-2 h-2 w-2 rounded-full bg-red-500"></span>
        </button>

        <x-dashboard.user-menu
            :name="$user->name"
            :role="$roleLabels[$user->account_type] ?? 'Usuário'"
            :email="$user->email"
            :phone="$user->phone"
        />
    </div>
</header>
