@props([
    'action' => '#',
    'method' => 'POST',
])

<form action="{{ $action }}" method="{{ $method === 'GET' ? 'GET' : 'POST' }}" class="flex flex-col gap-5">
    @csrf
    @if(! in_array(strtoupper($method), ['GET', 'POST']))
        @method($method)
    @endif

    <x-ui.select
        label="Tipo de Conta"
        name="account_type"
        :options="['cliente' => 'Cliente', 'profissional' => 'Profissional']"
        value="cliente"
        required
    />

    <x-ui.input
        label="Nome Completo *"
        name="name"
        type="text"
        placeholder="Seu nome completo"
        autocomplete="name"
        required
    />

    <x-ui.input
        label="Email *"
        name="email"
        type="email"
        placeholder="seu@email.com"
        autocomplete="email"
        required
    />

    <x-ui.input
        label="Telefone"
        name="phone"
        type="tel"
        placeholder="(00) 00000-0000"
        autocomplete="tel"
    />

    <x-ui.password-input
        label="Senha *"
        name="password"
        autocomplete="new-password"
        required
    />

    <x-ui.password-input
        label="Confirmar Senha *"
        name="password_confirmation"
        autocomplete="new-password"
        required
    />

    <x-ui.button type="submit" class="mt-1 w-full">
        Cadastrar
    </x-ui.button>
</form>
