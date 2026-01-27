<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class FotoAlbum extends Model
{
    use HasFactory;

    // Nome da tabela associada à model (opcional)
    protected $table = 'foto_album';

    // Ajustar o primary key
    protected $primaryKey = 'fa_id';
    //public $incrementing = true;
    

    // Colunas que podem ser preenchidas em massa (opcional)
    protected $fillable = ['alb_id', 'fp_data', 'fp_bucket', 'fp_hash'];

    public function album(): HasOne
    {
        return $this->HasOne(Album::class, 'alb_id');
    }
}
