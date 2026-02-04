<?php

namespace App\Livewire\Artista;

use App\Models\Artista;
use Livewire\Component;
use Livewire\WithPagination;

class Manage extends Component
{
    use WithPagination;

    public $art_nome, $art_descricao, $artista_id;
    public $isModalOpen = false;
    public $search = '';

    protected function rules()
    {
        return [
            'art_nome' => [
                'required',
                'string',
                'min:3',
                // Se artista_id for nulo, ele ignora o parâmetro de exclusão
                $this->artista_id 
                    ? 'unique:artista,art_nome,' . $this->artista_id 
                    : 'unique:artista,art_nome'
            ],
            'art_descricao' => 'required|string|min:5',
        ];
    }

    public function render()
    {
        $artistas = Artista::where('art_nome', 'ILIKE', '%' . $this->search . '%')
            ->orderBy('art_nome')
            ->paginate(10);        

        return view('livewire.artista.manage', [
            'artistas' => $artistas
        ])->layout('layouts.admin', [
            'title' => 'Artistas'
        ]);
    }

    public function create()
    {
        $this->resetInputFields();
        $this->openModal();
    }

    public function openModal() 
    { 
        $this->isModalOpen = true; 
        // Dispara o evento para o Alpine.js abrir o modal
        $this->dispatch('open-modal', 'modal-form-artista');
    }

    public function closeModal() 
    { 
        $this->isModalOpen = false; 
        // Dispara o evento para o Alpine.js fechar o modal
        $this->dispatch('close-modal', 'modal-form-artista');
    }

    private function resetInputFields()
    {
        $this->art_nome = '';
        $this->art_descricao = '';
        $this->artista_id = null;
    }

    public function store()
    {
        $validated = $this->validate(); // Isso usa as rules() ajustadas acima

        Artista::updateOrCreate(['id' => $this->artista_id], [
            'art_nome' => $this->art_nome,
            'art_descricao' => $this->art_descricao,
        ]);

        session()->flash('message', $this->artista_id ? 'Artista atualizado!' : 'Artista cadastrado!');
        
        $this->closeModal();
        $this->resetInputFields();
    }

    public function edit($id)
    {
        $artista = Artista::findOrFail($id);
        $this->artista_id = $id;
        $this->art_nome = $artista->art_nome;
        $this->art_descricao = $artista->art_descricao;
        $this->openModal();
    }

    public function delete($id)
    {
        Artista::findOrFail($id)->delete();
        session()->flash('message', 'Artista excluído com sucesso.');
    }
}