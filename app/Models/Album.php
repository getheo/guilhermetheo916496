<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    use HasFactory;

    // Nome da tabela associada à model (opcional)
    protected $table = 'album';

    // Ajustar o primary key
    //protected $primaryKey = 'alb_id';
    //public $incrementing = true; 
    

    // Colunas que podem ser preenchidas em massa (opcional)
    protected $fillable = ['alb_nome', 'alb_descricao', 'alb_data_lancamento', 'artista_id'];

    public function artista()
    {
        return $this->belongsTo(Artista::class, 'artista_id');
    }

}
