<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'AgendaFácil' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-brand-50 font-sans antialiased">
    <x-ui.toast-container />

    <main class="flex min-h-screen items-center justify-center px-4 py-10">
        {{ $slot }}
    </main>
</body>
</html>
