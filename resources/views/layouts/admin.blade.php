<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>{{ $title ?? 'Painel' }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body class="bg-gray-100 text-gray-800">
<div class="min-h-screen flex">

    {{-- Sidebar --}}
    <aside class="w-64 bg-white border-r">
        <div class="p-4 font-bold border-b">
            🎵 Music Admin
        </div>

        <nav class="p-4 space-y-2 text-sm">
            <a href="/artistas" class="block px-3 py-2 rounded hover:bg-gray-100">
                Artistas
            </a>
            <a href="/albuns" class="block px-3 py-2 rounded hover:bg-gray-100">
                Álbuns
            </a>
            <a href="/musicas" class="block px-3 py-2 rounded hover:bg-gray-100">
                Músicas
            </a>
        </nav>
    </aside>

    {{-- Conteúdo --}}
    <main class="flex-1">
        <header class="bg-white border-b p-4">
            <h1 class="font-semibold">
                {{ $title ?? '' }}
            </h1>
        </header>

        <section class="p-6">
            {{ $slot }}
        </section>
    </main>

</div>

@livewireScripts
</body>
</html>