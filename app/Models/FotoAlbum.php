<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FotoAlbum extends Model
{
    use HasFactory;

    // Nome da tabela (singular conforme seu padrão)
    protected $table = 'foto_album';

    // Desative os timestamps se o banco de dados não tiver created_at/updated_at
    // public $timestamps = false;

    // Colunas que podem ser preenchidas em massa
    protected $fillable = [
        'album_id', 
        'fa_data', 
        'fa_bucket', 
        'fa_hash'
    ];

    /**
     * Relacionamento: Esta foto PERTENCE a um álbum.
     * * Usamos BelongsTo porque a chave estrangeira (album_id) está nesta tabela.
     */
    public function album(): BelongsTo
    {
        return $this->belongsTo(Album::class, 'album_id');
    }
}