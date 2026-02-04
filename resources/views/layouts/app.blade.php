<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <style>
            :root {
                --brand-color: #232c77;
                --brand-hover: #1a215a;
            }
            /* Sobrescrevendo classes utilitárias para usar a cor da marca */
            .bg-brand { background-color: var(--brand-color) !important; }
            .text-brand { color: var(--brand-color) !important; }
            .border-brand { border-color: var(--brand-color) !important; }
        </style>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
    </head>
    <body class="font-sans antialiased bg-gray-50">
        <div class="min-h-screen">
            <livewire:layout.navigation />

            @if (isset($header))
                <header class="bg-brand shadow-lg">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        <div class="text-white">
                            {{ $header }}
                        </div>
                    </div>
                </header>
            @endif

            <main>
                {{ $slot }}
            </main>
        </div>

        @livewireScripts
    </body>
</html>