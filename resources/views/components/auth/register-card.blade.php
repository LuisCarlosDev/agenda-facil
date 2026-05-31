@props([
    'action' => '#',
    'backUrl' => '#',
])

<x-ui.card>
    <x-auth.register-header :back-url="$backUrl" />

    <x-auth.register-form :action="$action" />
</x-ui.card>
