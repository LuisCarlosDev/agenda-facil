@props([
    'backUrl' => '#',
])

<header class="mb-8">
    <a
        href="{{ $backUrl }}"
        class="mb-6 inline-flex items-center gap-1 text-sm font-medium text-muted transition hover:text-heading"
    >
        <span aria-hidden="true">←</span>
        Voltar
    </a>

    <div class="text-center">
        <h1 class="text-2xl font-bold tracking-tight text-heading">Criar Conta</h1>
        <p class="mt-2 text-sm text-muted">Preencha os dados abaixo</p>
    </div>
</header>
