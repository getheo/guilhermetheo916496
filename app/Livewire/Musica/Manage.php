<?php

namespace App\Livewire\Musica;

use App\Models\Musica;
use App\Models\Album;
use Livewire\Component;
use Livewire\WithPagination;

class Manage extends Component
{
    use WithPagination;

    public $mus_titulo, $album_id, $musica_id;
    public $isModalOpen = false;
    public $search = '';

    protected function rules()
    {
        return [
            'album_id' => 'required|exists:album,id',
            'mus_titulo' => 'required|string|min:1',
        ];
    }

    public function render()
    {
        $pesquisaSegura = str_replace(['%', '_'], ['\%', '\_'], $this->search);

        $musicas = Musica::with(['album.artista'])
            ->where('mus_titulo', 'ILIKE', '%' . $pesquisaSegura . '%')
            ->orderBy('mus_titulo')
            ->paginate(15);

        $albums = Album::orderBy('alb_titulo')->get();

        return view('livewire.musica.manage', [
            'musicas' => $musicas,
            'albums' => $albums
        ])->layout('layouts.admin', [
            'title' => 'Músicas'
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
        $this->dispatch('open-modal', 'modal-form-musica');
    }

    public function closeModal() 
    { 
        $this->isModalOpen = false; 
        $this->dispatch('close-modal', 'modal-form-musica');
    }

    private function resetInputFields()
    {
        $this->mus_titulo = '';
        $this->album_id = '';
        $this->musica_id = null;
    }

    public function store()
    {
        $this->validate();

        Musica::updateOrCreate(['id' => $this->musica_id], [
            'album_id' => $this->album_id,
            'mus_titulo' => $this->mus_titulo,
        ]);

        session()->flash('message', $this->musica_id ? 'Música atualizada!' : 'Música adicionada!');
        
        $this->closeModal();
        $this->resetInputFields();
    }

    public function edit($id)
    {
        $musica = Musica::findOrFail($id);
        $this->musica_id = $id;
        $this->mus_titulo = $musica->mus_titulo;
        $this->album_id = $musica->album_id;
        $this->openModal();
    }

    public function delete($id)
    {
        Musica::findOrFail($id)->delete();
        session()->flash('message', 'Música removida.');
    }
}