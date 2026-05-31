@props([
    'registerUrl' => '#',
])

<p class="mt-6 text-center text-sm text-muted">
    Não tem uma conta?
    <x-ui.link :href="$registerUrl">Cadastre-se</x-ui.link>
</p>
