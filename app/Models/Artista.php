<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Artista extends Model
{
    use HasFactory;

    // Nome da tabela associada à model (opcional)
    protected $table = 'artista';

    // Ajustar o primary key
    //protected $primaryKey = 'art_id';
    //public $incrementing = true;
    

    // Colunas que podem ser preenchidas em massa (opcional)
    protected $fillable = ['art_nome', 'art_descricao', 'art_status'];

    public function albuns()
    {
        return $this->hasMany(Album::class);
    }

    public function foto()
    {
        return $this->hasMany(FotoArtista::class);
    }
}
