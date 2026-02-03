<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Inventaire Centralisé IT</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <script src="https://cdn.tailwindcss.com"></script>
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        <style>[x-cloak] { display: none !important; }</style>
        @livewireStyles
    </head>
    <body class="antialiased bg-slate-50">
        <div class="min-h-screen">
            
            @include('layouts.navigation')

            <main>
                {{ $slot }}
            </main>
        </div>
        @livewireScripts
    </body>
</html>