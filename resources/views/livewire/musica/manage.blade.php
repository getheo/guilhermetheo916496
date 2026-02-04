<div class="p-6">
    <div class="flex justify-between items-center mb-6">     
        <h2 class="text-2xl font-bold text-[#232c77]">Gerenciar Músicas</h2>   
        <button wire:click="create()" class="bg-[#232c77] hover:bg-[#1a215a] text-white px-4 py-2 rounded-lg transition font-semibold shadow-md">
            + Nova Música
        </button>
    </div>

    @if (session()->has('message'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 shadow-sm rounded-md">
            {{ session('message') }}
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        
        <div class="px-6 py-4">
            <h3 class="text-xl font-bold text-[#232c77]">Gerenciar Músicas</h3>
        </div>

        <div class="px-6 pb-4">
            <div class="relative w-full md:w-72">
                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg>
                </span>
                <input wire:model.live.debounce.300ms="search" type="text" placeholder="Pesquisar música..." 
                       class="pl-10 w-full border-gray-200 rounded-lg text-sm focus:border-[#232c77] focus:ring-1 focus:ring-[#232c77] py-2">
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full leading-normal">
                <thead>
                    <tr class="bg-[#232c77] text-white">
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Título</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Álbum</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Artista</th>
                        <th class="px-6 py-3 text-center text-xs font-semibold uppercase tracking-wider">Ações</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($musicas as $musica)
                        <tr class="hover:bg-gray-50/50 transition duration-150">
                            <td class="px-6 py-4 text-sm font-bold text-gray-900">
                                {{ $musica->mus_titulo }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                {{ $musica->album->alb_titulo ?? 'N/A' }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500 italic">
                                {{ $musica->album->artista->art_nome ?? 'Desconhecido' }}
                            </td>
                            <td class="px-6 py-4 text-sm text-center">
                                <button wire:click="edit({{ $musica->id }})" class="text-[#232c77] hover:text-[#1a215a] font-semibold mr-3 underline">Editar</button>
                                <button onclick="confirm('Excluir música?') || event.stopImmediatePropagation()" 
                                        wire:click="delete({{ $musica->id }})" 
                                        class="text-red-600 hover:text-red-900 font-semibold underline">Excluir</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-10 text-center text-gray-500 text-sm italic">
                                Nenhuma música encontrada.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-6 py-4 bg-white border-t border-gray-100">
            {{ $musicas->links() }}
        </div>
    </div>

    @if($isModalOpen)
    <div class="fixed inset-0 z-[9999] overflow-y-auto">
        <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity" wire:click="closeModal"></div>

        <div class="flex items-center justify-center min-h-screen p-4 text-center sm:p-0">
            <div class="relative bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:max-w-lg sm:w-full border-t-8 border-[#232c77] z-[10000]">
                
                <button type="button" wire:click="closeModal" class="absolute top-4 right-4 text-gray-400 hover:text-gray-700 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>

                <form wire:submit.prevent="store" class="p-8">
                    <h3 class="text-2xl font-bold mb-6 text-gray-800">
                        {{ $musica_id ? 'Editar Faixa' : 'Nova Faixa' }}
                    </h3>

                    <div class="space-y-5">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Álbum Pertencente</label>
                            <select wire:model="album_id" class="w-full border-gray-300 rounded-lg focus:ring-[#232c77] focus:border-[#232c77] transition shadow-sm">
                                <option value="">Selecione o álbum...</option>
                                @foreach($albums as $album)
                                    <option value="{{ $album->id }}">{{ $album->alb_titulo }} ({{ $album->artista->art_nome ?? 'S/A' }})</option>
                                @endforeach
                            </select>
                            @error('album_id') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Título da Música</label>
                            <input type="text" wire:model="mus_titulo" 
                                   class="w-full border-gray-300 rounded-lg focus:ring-[#232c77] focus:border-[#232c77] transition shadow-sm"
                                   placeholder="Ex: Bohemian Rhapsody">
                            @error('mus_titulo') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="mt-8 flex justify-end space-x-3 bg-gray-50 -mx-8 -mb-8 p-6">
                        <button type="button" wire:click="closeModal" class="px-5 py-2 text-gray-600 font-semibold hover:text-gray-800 transition">
                            Cancelar
                        </button>
                        <button type="submit" wire:loading.attr="disabled"
                                class="bg-[#232c77] text-white px-8 py-2 rounded-xl font-bold hover:bg-[#1a215a] shadow-lg transition transform active:scale-95">
                            <span wire:loading.remove wire:target="store">Confirmar</span>
                            <span wire:loading wire:target="store">Salvando...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif
</div>