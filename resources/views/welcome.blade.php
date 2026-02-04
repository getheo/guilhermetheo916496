<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Music Admin - Gestão Musical</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased font-sans text-gray-900 bg-gray-50">
        <div class="relative min-h-screen">
            
            <nav class="flex justify-between items-center p-6 bg-white shadow-sm border-b border-gray-100">
                <div class="flex items-center space-x-2 text-[#232c77]">
                    <div class="p-2 bg-blue-50 rounded-lg">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"></path>
                        </svg>
                    </div>
                    <span class="text-xl font-bold tracking-tight">Music Admin</span>
                </div>

                @if (Route::has('login'))
                    <div class="z-10">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="font-semibold text-gray-600 hover:text-[#232c77] transition">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="font-semibold text-gray-600 hover:text-[#232c77] transition mr-6">Entrar</a>
                            
                        @endauth
                    </div>
                @endif
            </nav>

            <main class="max-w-7xl mx-auto px-6 lg:px-8 pt-20 pb-16">
                <div class="text-center">
                    <h1 class="text-5xl md:text-6xl font-extrabold text-[#232c77] mb-6 leading-tight mt-5">
                        Sistema de Gerenciamento de Artistas, Albúns e Músicas
                    </h1>
                    <p class="text-xl text-gray-500 max-w-2xl mx-auto mb-10">
                        Este projeto foi desenvolvido exclusivamente para o PROCESSO SELETIVO CONJUNTO Nº 001/2026/SEPLAG e demais Órgãos - Engenheiro da Computação- Sênior.
                    </p>

                    <div class="flex justify-center items-center space-x-4 space-y-0 flex-wrap mb-5">
                        <a href="{{ route('login') }}" class="inline-flex items-center px-4 py-2 bg-[#232c77] border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-[#1a215a] focus:bg-[#1a215a] active:bg-[#151a46] focus:outline-none focus:ring-2 focus:ring-[#232c77] focus:ring-offset-2 transition ease-in-out duration-150 ms-4">
                            Entrar no Sistema
                        </a>
                    </div>
                    
                </div>

                <div class="mt-24 grid grid-cols-1 md:grid-cols-3 gap-8">
                    
                    <div class="group bg-white p-8 rounded-3xl shadow-sm border border-gray-100 hover:border-blue-200 hover:shadow-xl hover:shadow-blue-900/5 transition-all duration-300">
                        <div class="w-14 h-14 bg-blue-50 text-[#232c77] rounded-2xl flex items-center justify-center mb-6 group-hover:bg-[#232c77] group-hover:text-white transition-colors duration-300">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 mb-3">Galeria de Capas</h3>
                        <p class="text-gray-500 leading-relaxed">Gerenciamento visual de artes com suporte a storage externo e processamento de imagens.</p>
                    </div>

                    <div class="group bg-white p-8 rounded-3xl shadow-sm border border-gray-100 hover:border-blue-200 hover:shadow-xl hover:shadow-blue-900/5 transition-all duration-300">
                        <div class="w-14 h-14 bg-blue-50 text-[#232c77] rounded-2xl flex items-center justify-center mb-6 group-hover:bg-[#232c77] group-hover:text-white transition-colors duration-300">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 mb-3">Artistas & Bandas</h3>
                        <p class="text-gray-500 leading-relaxed">Cadastro detalhado de perfis musicais e vinculação inteligente com discografias completas.</p>
                    </div>

                    <div class="group bg-white p-8 rounded-3xl shadow-sm border border-gray-100 hover:border-blue-200 hover:shadow-xl hover:shadow-blue-900/5 transition-all duration-300">
                        <div class="w-14 h-14 bg-blue-50 text-[#232c77] rounded-2xl flex items-center justify-center mb-6 group-hover:bg-[#232c77] group-hover:text-white transition-colors duration-300">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 mb-3">Controle de Mídias</h3>
                        <p class="text-gray-500 leading-relaxed">Acompanhe o status de cada lançamento e organize metadados essenciais para sua biblioteca.</p>
                    </div>

                </div>
            </main>

            <footer class="text-center py-12 text-gray-400 text-sm">
                &copy; {{ date('Y') }} Music Admin &bull; Sistema de Gestão Interna
            </footer>
        </div>
    </body>
</html>