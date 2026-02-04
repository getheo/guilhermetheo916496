<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-[#232c77]">Gerenciar Álbuns</h2>
        <button wire:click="openModal" class="bg-[#232c77] hover:bg-[#1a215a] text-white px-4 py-2 rounded-lg transition font-semibold shadow-md">
            + Novo Álbum
        </button>
    </div>

    @if (session()->has('message'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 shadow-sm rounded-md">
            {{ session('message') }}
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        
        <div class="p-4 border-b border-gray-100 bg-white">
            <div class="relative w-full md:w-72">
                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg>
                </span>
                <input wire:model.live.debounce.300ms="search" type="text" placeholder="Pesquisar álbum..." 
                       class="pl-10 w-full border-gray-200 rounded-lg text-sm focus:border-[#232c77] focus:ring-1 focus:ring-[#232c77] py-2">
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full leading-normal">
                <thead>
                    <tr class="bg-[#232c77] text-white">
                        <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider">Capa</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider">Título do Álbum</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider">Artista</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider">Status</th>
                        <th class="px-5 py-3 text-center text-xs font-semibold uppercase tracking-wider">Ações</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($albuns as $album)
                        <tr class="hover:bg-gray-50/50 transition duration-150">
                            <td class="px-5 py-4">
                                <div class="w-10 h-10">
                                    @if($album->foto_url)
                                        <img class="w-full h-full rounded-md object-cover border border-gray-100" 
                                             src="{{ $album->foto_url }}" alt="Capa">
                                    @else
                                        <div class="w-full h-full rounded-md bg-gray-100 flex items-center justify-center text-gray-400">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        </div>
                                    @endif
                                </div>
                            </td>
                            <td class="px-5 py-4 text-sm font-bold text-gray-900">
                                {{ $album->alb_titulo }}
                            </td>
                            <td class="px-5 py-4 text-sm text-gray-600">
                                {{ $album->artista->art_nome ?? 'N/A' }}
                            </td>
                            <td class="px-5 py-4 text-sm">
                                <span class="px-3 py-1 text-xs font-bold rounded-full {{ $album->alb_status == 'Ativo' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                    {{ $album->alb_status }}
                                </span>
                            </td>
                            <td class="px-5 py-4 text-sm text-center">
                                <button wire:click="edit({{ $album->id }})" class="text-[#232c77] hover:text-[#1a215a] font-semibold mr-3 underline">Editar</button>
                                <button onclick="confirm('Tem certeza?') || event.stopImmediatePropagation()" 
                                        wire:click="delete({{ $album->id }})" 
                                        class="text-red-600 hover:text-red-900 font-semibold underline">Excluir</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-5 py-10 text-center text-gray-500 text-sm">
                                Nenhum álbum encontrado.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-5 py-4 bg-white border-t border-gray-100">
            {{ $albuns->links() }}
        </div>
    </div>

    @if($isModalOpen)
        @endif
</div>