<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'AgendaFácil' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="overflow-hidden bg-brand-50 font-sans antialiased">
    <x-ui.toast-container />

    <div class="flex h-screen">
        <x-dashboard.sidebar />

        <div class="ml-64 flex h-screen flex-1 flex-col overflow-hidden">
            <x-dashboard.header />

            <main class="flex-1 overflow-y-auto px-6 py-8">
                {{ $slot }}
            </main>

            <x-dashboard.footer />
        </div>
    </div>
</body>
</html>
