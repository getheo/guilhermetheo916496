<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ArtistaAlbum extends Model
{
    use HasFactory;

    // Nome da tabela associada à model (opcional)
    protected $table = 'artista_album';

    // Ajustar primary key
    //protected $primaryKey = 'art_alb_id';
    //public $incrementing = true;


    // Colunas que podem ser preenchidas em massa (opcional)
    protected $fillable = ['artista_id', 'album_id'];

    public function artista(): BelongsTo
    {
        return $this->belongsTo(Artista::class, 'artista_id');
    }

    public function album()
    {
        return $this->belongsTo(Album::class, 'album_id');
    }
}
