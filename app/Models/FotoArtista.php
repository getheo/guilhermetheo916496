<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FotoArtista extends Model
{
    use HasFactory;

    // Define o nome da tabela caso não seja o plural automático (foto_artistas)
    protected $table = 'foto_artista';

    // Permite a inserção de dados nestas colunas
    protected $fillable = [
        'artista_id',
        'fa_data',
        'fa_bucket',
        'fa_hash'
    ];

    /**
     * Relacionamento: Uma foto pertence a um artista
     */
    public function artista()
    {
        return $this->belongsTo(Artista::class, 'artista_id');
    }
}