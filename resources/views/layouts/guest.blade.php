<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{'Inventaire Centralisé IT' }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <style>
            @keyframes float {
                0% { transform: translateY(0px); }
                50% { transform: translateY(-10px); }
                100% { transform: translateY(0px); }
            }

            .logo-animation {
                animation: fadeInDown 0.8s ease-out, float 4s ease-in-out infinite;
            }

            @keyframes fadeInDown {
                from { opacity: 0; transform: translateY(-20px); }
                to { opacity: 1; transform: translateY(0); }
            }
        </style>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100 mb-10 text-center logo-animation">
                    <div class="mb-10 text-center">
            <a href="/" class="inline-block group">
                <x-application-logo class="h-24 w-auto drop-shadow-2xl transition-transform duration-500 group-hover:scale-110 group-active:scale-95" />
            </a>
            
            <h2 class="text-xl font-black tracking-tight mt-6 text-slate-800 uppercase group-hover:text-indigo-600 transition-colors">
                Inventaire Centralisé
            </h2>
        </div>

            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
