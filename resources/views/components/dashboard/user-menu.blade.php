@props([
    'name' => '',
    'role' => '',
    'email' => '',
    'phone' => null,
])

<button
    type="button"
    data-dialog-open="user-menu"
    {{ $attributes->merge([
        'class' => 'flex items-center gap-3 rounded-lg px-2 py-1.5 text-left transition hover:bg-brand-50',
    ]) }}
    aria-label="Abrir menu do usuário"
>
    <div class="flex h-10 w-10 items-center justify-center rounded-full bg-brand-500 text-white">
        <x-ui.icons.user class="h-5 w-5" />
    </div>

    <div class="hidden sm:block">
        <p class="text-sm font-semibold text-heading">{{ $name }}</p>
        <p class="text-xs text-muted">{{ $role }}</p>
    </div>
</button>

<x-ui.dialog id="user-menu" title="Minha Conta">
    <div class="mt-5 flex flex-col items-center text-center">
        <div class="flex h-16 w-16 items-center justify-center rounded-full bg-brand-500 text-white">
            <x-ui.icons.user class="h-8 w-8" />
        </div>

        <p class="mt-4 text-base font-semibold text-heading">{{ $name }}</p>
        <p class="text-sm text-muted">{{ $role }}</p>
    </div>

    <dl class="mt-6 space-y-3 border-t border-border pt-5">
        <div>
            <dt class="text-xs font-medium uppercase tracking-wide text-muted">Email</dt>
            <dd class="mt-1 text-sm text-heading">{{ $email }}</dd>
        </div>

        @if($phone)
            <div>
                <dt class="text-xs font-medium uppercase tracking-wide text-muted">Telefone</dt>
                <dd class="mt-1 text-sm text-heading">{{ $phone }}</dd>
            </div>
        @endif
    </dl>

    <form action="{{ route('logout') }}" method="POST" class="mt-6">
        @csrf

        <x-ui.button
            type="submit"
            variant="outline"
            class="w-full gap-2 text-red-600 hover:bg-red-50 hover:text-red-700"
        >
            <x-ui.icons.logout class="h-5 w-5" />
            Sair
        </x-ui.button>
    </form>
</x-ui.dialog>
