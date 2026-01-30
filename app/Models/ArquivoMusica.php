<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArquivoMusica extends Model
{
    use HasFactory;

    // Define o nome da tabela caso não seja o plural automático (arquivo_musica
    protected $table = 'arquivo_musica';

    // Permite a inserção de dados nestas colunas
    protected $fillable = [
        'album_id',
        'fa_data',
        'fa_bucket',
        'fa_hash'
    ];

    /**
     * Relacionamento: Uma foto pertence a um album
     */
    public function album()
    {
        return $this->belongsTo(Album::class, 'album_id');
    }
}
