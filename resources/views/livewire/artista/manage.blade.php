<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-[#232c77]">Gerenciar Artistas</h2>
        <button wire:click="create()" class="bg-[#232c77] hover:bg-[#1a215a] text-white px-4 py-2 rounded-lg transition font-semibold shadow-md">
            + Novo Artista
        </button>
    </div>

    @if (session()->has('message'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 shadow-sm">
            {{ session('message') }}
        </div>
    @endif

    <div class="overflow-x-auto bg-white rounded-lg shadow">
        <div class="p-4 border-b border-gray-100 bg-gray-50/50">
            <input wire:model.live.debounce.300ms="search" type="text" placeholder="Pesquisar artista..." 
                   class="w-full md:w-64 border-gray-300 rounded-md shadow-sm focus:border-[#232c77] focus:ring-[#232c77] text-sm">
        </div>

        <table class="min-w-full leading-normal">
            <thead>
                <tr class="bg-[#232c77] text-white">
                    <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold uppercase tracking-wider">ID</th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold uppercase tracking-wider">Nome do Artista</th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold uppercase tracking-wider">Descrição</th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 text-center text-xs font-semibold uppercase tracking-wider">Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse($artistas as $artista)
                    <tr class="hover:bg-gray-50 transition duration-150">
                        <td class="px-5 py-5 border-b border-gray-200 text-sm text-gray-600">
                            #{{ $artista->id }}
                        </td>
                        <td class="px-5 py-5 border-b border-gray-200 text-sm font-bold text-gray-900">
                            {{ $artista->art_nome }}
                        </td>
                        <td class="px-5 py-5 border-b border-gray-200 text-sm text-gray-600">
                            {{ Str::limit($artista->art_descricao, 50) ?: 'N/A' }}
                        </td>
                        <td class="px-5 py-5 border-b border-gray-200 text-sm text-center">
                            <button wire:click="edit({{ $artista->id }})" class="text-[#232c77] hover:text-[#1a215a] font-semibold mr-3 underline">Editar</button>
                            <button onclick="confirm('Tem certeza?') || event.stopImmediatePropagation()" 
                                    wire:click="delete({{ $artista->id }})" 
                                    class="text-red-600 hover:text-red-900 font-semibold underline">Excluir</button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-5 py-5 border-b border-gray-200 text-sm text-center text-gray-500">
                            Nenhum artista encontrado.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="px-5 py-5 bg-white border-t">
            {{ $artistas->links() }}
        </div>
    </div>

    @if($isModalOpen)
    <div class="fixed inset-0 z-[9999] overflow-y-auto">
        <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity" wire:click="closeModal"></div>

        <div class="flex items-center justify-center min-h-screen p-4 text-center sm:p-0">
            <div class="relative bg-white rounded-2xl text-left overflow-hidden shadow-[0_25px_50px_-12px_rgba(0,0,0,0.5)] transform transition-all sm:my-8 sm:max-w-lg sm:w-full border-t-8 border-[#232c77] z-[10000]">
                
                <button type="button" wire:click="closeModal" class="absolute top-4 right-4 text-gray-400 hover:text-gray-700 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>

                <form wire:submit.prevent="store" class="p-8">
                    <h3 class="text-2xl font-bold mb-6 text-gray-800">
                        {{ $artista_id ? 'Editar Artista' : 'Novo Artista' }}
                    </h3>

                    <div class="space-y-5">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Nome do Artista</label>
                            <input type="text" wire:model="art_nome" 
                                   class="w-full border-gray-300 rounded-lg focus:ring-[#232c77] focus:border-[#232c77] transition shadow-sm"
                                   placeholder="Ex: AC/DC">
                            @error('art_nome') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Descrição</label>
                            <textarea wire:model="art_descricao" rows="4"
                                      class="w-full border-gray-300 rounded-lg focus:ring-[#232c77] focus:border-[#232c77] transition shadow-sm"
                                      placeholder="Breve biografia..."></textarea>
                            @error('art_descricao') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="mt-8 flex justify-end space-x-3 bg-gray-50 -mx-8 -mb-8 p-6">
                        <button type="button" wire:click="closeModal"
                                class="px-5 py-2 text-gray-600 font-semibold hover:text-gray-800 transition">
                            Cancelar
                        </button>

                        <button type="submit" wire:loading.attr="disabled"
                                class="bg-[#232c77] text-white px-8 py-2 rounded-xl font-bold hover:bg-[#1a215a] shadow-lg shadow-blue-900/20 transition transform active:scale-95">
                            <span wire:loading.remove wire:target="store">
                                {{ $artista_id ? 'Atualizar Artista' : 'Salvar Artista' }}
                            </span>
                            <span wire:loading wire:target="store">Salvando...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif
</div>