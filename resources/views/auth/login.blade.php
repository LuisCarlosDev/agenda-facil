<x-layouts.auth title="Login — AgendaFácil">
    <x-auth.login-card
        :action="route('login.store')"
        :register-url="route('register')"
    />
</x-layouts.auth>
