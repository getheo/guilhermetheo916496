<?php

namespace App\Livewire\Album;

use App\Models\Album;
use App\Models\Artista;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class Manage extends Component
{
    use WithPagination, WithFileUploads;

    public $alb_titulo, $artista_id, $alb_status, $alb_data_lancamento, $album_id, $capa;
    public $isModalOpen = false;
    public $search = '';

    // Define o tema da paginação para Tailwind (evita botões gigantes)
    protected $paginationTheme = 'tailwind';

    protected function rules()
    {
        return [
            'artista_id' => 'required|exists:artista,id',
            'alb_titulo' => 'required|string|min:2',
            'alb_status' => 'nullable|string',
            'alb_data_lancamento' => 'nullable|date',
            'capa' => 'nullable|image|max:1024', 
        ];
    }

    public function render()
    {
        return view('livewire.album.manage', [
            'albuns' => Album::with('artista')
                ->where('alb_titulo', 'ilike', '%' . $this->search . '%') 
                ->orderBy('created_at', 'desc')
                ->paginate(10),
            'artistas' => Artista::all(), 
        ])->layout('layouts.admin', [
            'title' => 'Álbuns'
        ]);
    }

    public function store()
    {
        $this->validate();

        $album = Album::find($this->album_id);
        $dados = [
            'artista_id' => $this->artista_id,
            'alb_titulo' => $this->alb_titulo,
            'alb_status' => $this->alb_status ? true : false,
            'alb_data_lancamento' => $this->alb_data_lancamento,
        ];

        if ($this->capa) {
            if ($album && $album->capa_path) {
                Storage::disk('s3')->delete($album->capa_path);
            }

            $path = $this->capa->store('capas_albuns', 's3');
            $dados['capa_path'] = $path;
        }

        Album::updateOrCreate(['id' => $this->album_id], $dados);

        session()->flash('message', $this->album_id ? 'Álbum atualizado!' : 'Álbum criado!');
        
        $this->closeModal();
        $this->resetInputFields();
    }

    public function edit($id)
    {
        $album = Album::findOrFail($id);
        $this->album_id = $id;
        $this->artista_id = $album->artista_id;
        $this->alb_titulo = $album->alb_titulo;
        $this->alb_status = $album->alb_status;
        $this->alb_data_lancamento = $album->alb_data_lancamento;
        
        $this->openModal();
    }

    public function delete($id)
    {
        $album = Album::findOrFail($id);
        if ($album->capa_path) {
            Storage::disk('s3')->delete($album->capa_path);
        }
        $album->delete();
        session()->flash('message', 'Álbum excluído com sucesso!');
    }

    public function openModal()
    {
        $this->isModalOpen = true;
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
        $this->resetInputFields();
    }

    private function resetInputFields()
    {
        $this->reset(['alb_titulo', 'artista_id', 'alb_status', 'alb_data_lancamento', 'album_id', 'capa']);
    }
}