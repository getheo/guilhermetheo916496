<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Gerenciar Artistas') }}
    </h2>
</x-slot>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
            
            @if (session()->has('message'))
                <div class="mb-4 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded">
                    {{ session('message') }}
                </div>
            @endif

            <div class="flex justify-between items-center mb-4">
                <input wire:model.live.debounce.300ms="search" type="text" placeholder="Pesquisar artista..." class="border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                <x-primary-button wire:click="create()">Novo Artista</x-primary-button>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse border border-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="p-3 border-b">ID</th>
                            <th class="p-3 border-b">Nome</th>
                            <th class="p-3 border-b">Descrição</th>
                            <th class="p-3 border-b text-center">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($artistas as $artista)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="p-3 border-b text-gray-600">{{ $artista->id }}</td>
                            <td class="p-3 border-b font-bold text-blue-700">{{ $artista->art_nome }}</td>
                            <td class="p-3 border-b text-sm text-gray-600">{{ Str::limit($artista->art_descricao, 50) }}</td>
                            <td class="p-3 border-b text-center text-sm space-x-2">
                                <button wire:click="edit({{ $artista->id }})" class="text-indigo-600 hover:text-indigo-900 font-medium">Editar</button>
                                <button wire:click="delete({{ $artista->id }})" class="text-red-600 hover:text-red-900 font-medium" onclick="confirm('Tem certeza que deseja excluir?') || event.stopImmediatePropagation()">Excluir</button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="p-6 text-center text-gray-500 italic">Nenhum artista encontrado.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $artistas->links() }}
            </div>
        </div>
    </div>

    {{-- 
        Ajuste crucial: Adicionado o atributo 'name' para coincidir com o dispatch do Controller.
        Também mantemos o wire:model para sincronia de estado do Livewire.
    --}}
    <x-modal name="modal-form-artista" wire:model="isModalOpen" :show="$isModalOpen">
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900 mb-4 border-b pb-2">
                {{ $artista_id ? 'Editar Artista' : 'Cadastrar Artista' }}
            </h2>

            <form wire:submit.prevent="store" class="space-y-4">
                <div>
                    <x-input-label for="art_nome" value="Nome do Artista" />
                    <x-text-input wire:model="art_nome" id="art_nome" class="block mt-1 w-full" type="text" placeholder="Ex: Artista Exemplo" />
                    <x-input-error :messages="$errors->get('art_nome')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="art_descricao" value="Descrição" />
                    <textarea wire:model="art_descricao" id="art_descricao" rows="4" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" placeholder="Breve biografia ou detalhes..."></textarea>
                    <x-input-error :messages="$errors->get('art_descricao')" class="mt-2" />
                </div>

                <div class="mt-6 flex justify-end space-x-3">
                    <x-secondary-button wire:click="closeModal" type="button">
                        Cancelar
                    </x-secondary-button>
                    
                    <x-primary-button type="submit">
                        {{ $artista_id ? 'Atualizar Dados' : 'Salvar Cadastro' }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </x-modal>
</div>