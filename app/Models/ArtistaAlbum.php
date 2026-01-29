<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ArtistaAlbum extends Model
{
    use HasFactory;

    // Nome da tabela conforme sua migração
    protected $table = 'artista_album';

    /**
     * Colunas que podem ser preenchidas em massa.
     * Certifique-se de que esses nomes sejam exatamente iguais aos do seu banco.
     */
    protected $fillable = [
        'art_id', 
        'alb_id'
    ];

    /**
     * Relacionamento: O vínculo pertence a um Artista
     */
    public function artista(): BelongsTo
    {
        // 'art_id' é a chave estrangeira nesta tabela
        return $this->belongsTo(Artista::class, 'art_id');
    }

    /**
     * Relacionamento: O vínculo pertence a um Álbum
     */
    public function album(): BelongsTo
    {
        // 'alb_id' é a chave estrangeira nesta tabela
        return $this->belongsTo(Album::class, 'alb_id');
    }
}