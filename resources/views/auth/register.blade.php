<x-layouts.auth title="Criar Conta — AgendaFácil">
    <x-auth.register-card
        :action="route('register.store')"
        :back-url="route('login')"
    />
</x-layouts.auth>
