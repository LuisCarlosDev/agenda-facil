@props([
    'action' => '#',
    'method' => 'POST',
])

<form action="{{ $action }}" method="{{ $method === 'GET' ? 'GET' : 'POST' }}" class="flex flex-col gap-5">
    @csrf
    @if(! in_array(strtoupper($method), ['GET', 'POST']))
        @method($method)
    @endif

    <x-ui.input
        label="Email"
        name="email"
        type="email"
        placeholder="seu@email.com"
        autocomplete="email"
        required
    />

    <x-ui.password-input
        name="password"
        autocomplete="current-password"
        required
    />

    <x-ui.button type="submit" class="mt-1 w-full">
        Entrar
    </x-ui.button>
</form>
