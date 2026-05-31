@props([
    'name' => '',
])

<div {{ $attributes->merge(['class' => 'mb-8']) }}>
    <h1 class="text-2xl font-bold tracking-tight text-heading">Bem-vindo, {{ $name }}!</h1>
    <p class="mt-1 text-muted">Gerencie seus serviços e agendamentos</p>
</div>
