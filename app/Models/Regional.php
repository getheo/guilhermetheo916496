<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Regional extends Model
{
    use HasFactory;

    // Nome da tabela associada à model (opcional)
    protected $table = 'regional';

    // Colunas que podem ser preenchidas em massa (opcional)
    protected $fillable = ['nome', 'codigo'];
    
}
