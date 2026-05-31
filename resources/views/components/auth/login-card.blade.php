@props([
    'action' => '#',
    'registerUrl' => '#',
])

<x-ui.card>
    <x-auth.login-header />

    <x-auth.login-form :action="$action" />

    <x-auth.login-footer :register-url="$registerUrl" />
</x-ui.card>
