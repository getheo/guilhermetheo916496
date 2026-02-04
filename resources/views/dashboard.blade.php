<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-white leading-tight">
            {{ __('Painel de Controle') }}
        </h2>
    </x-slot>

    <style>
        .bg-brand { background-color: #232c77; }
        .text-brand { color: #232c77; }
        .border-brand { border-color: #232c77; }
        .hover-brand:hover { background-color: #1a215a; }
    </style>

    <div class="py-12 bg-gray-100 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="mb-8">
                <h3 class="text-2xl font-bold text-gray-800">Olá, {{ Auth::user()->name }}!</h3>                
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-10">
                
                <div class="bg-white rounded-xl shadow-sm border-l-8 border-brand p-6 flex items-center justify-between hover:shadow-md transition cursor-default">
                    <div>
                        <p class="text-sm font-semibold text-gray-400 uppercase tracking-wider">Artistas</p>
                        <p class="text-4xl font-black text-gray-900">{{ $totalArtistas ?? 0 }}</p>
                    </div>
                    <div class="p-3 bg-blue-50 rounded-full">
                        <svg class="w-8 h-8 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border-l-8 border-brand p-6 flex items-center justify-between hover:shadow-md transition cursor-default">
                    <div>
                        <p class="text-sm font-semibold text-gray-400 uppercase tracking-wider">Álbuns</p>
                        <p class="text-4xl font-black text-gray-900">{{ $totalAlbuns ?? 0 }}</p>
                    </div>
                    <div class="p-3 bg-blue-50 rounded-full">
                        <svg class="w-8 h-8 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"></path></svg>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border-l-8 border-brand p-6 flex items-center justify-between hover:shadow-md transition cursor-default">
                    <div>
                        <p class="text-sm font-semibold text-gray-400 uppercase tracking-wider">Músicas</p>
                        <p class="text-4xl font-black text-gray-900">{{ $totalMusicas ?? 0 }}</p>
                    </div>
                    <div class="p-3 bg-blue-50 rounded-full">
                        <svg class="w-8 h-8 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z"></path></svg>
                    </div>
                </div>

            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white p-8 rounded-xl shadow-sm border border-gray-100">
                    <h4 class="text-lg font-bold text-gray-800 mb-4">Gerenciamento Rápido</h4>
                    <div class="grid grid-cols-2 gap-4">
                        <a href="{{ route('artistas.index') }}" class="bg-brand text-white text-center py-3 rounded-lg font-semibold hover-brand transition shadow-lg">
                            Ver Artistas
                        </a>
                        <a href="{{ route('albuns.index') }}" class="border-2 border-brand text-brand text-center py-3 rounded-lg font-semibold hover:bg-blue-50 transition">
                            Ver Álbuns
                        </a>
                        <a href="{{ route('musicas.index') }}" class="border-2 border-brand text-brand text-center py-3 rounded-lg font-semibold hover:bg-blue-50 transition">
                            Ver Músicas
                        </a>
                    </div>
                </div>

                <div class="bg-brand p-8 rounded-xl shadow-sm text-white flex flex-col justify-center">
                    <h4 class="text-xl font-bold mb-2">Dica do Sistema</h4>
                    <p class="text-blue-100 opacity-80">Mantenha seus artistas atualizados para garantir que os álbuns e músicas apareçam corretamente nos relatórios da API.</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>