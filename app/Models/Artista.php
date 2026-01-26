<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Artista extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'descricao',
        'nacionalidade',
        'status',
    ];

    public function albuns()
    {
        return $this->hasMany(Album::class);
    }
}
