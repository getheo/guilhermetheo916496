<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Musica extends Model
{
    use HasFactory;

    // Nome da tabela associada à model (opcional)
    protected $table = 'musica';

    // Ajustar o primary key
    //protected $primaryKey = 'mus_id';
    //public $incrementing = true; 
    

    // Colunas que podem ser preenchidas em massa (opcional)
    protected $fillable = ['mus_nome', 'mus_duracao', 'mus_genero', 'album_id'];

    public function album()
    {
        return $this->belongsTo(Album::class, 'album_id');
    }

}
