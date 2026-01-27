<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Auth extends Model
{
    use HasFactory;

    // Nome da tabela associada à model (opcional)
    protected $table = 'users';

    // Colunas que podem ser preenchidas em massa (opcional)
    protected $fillable = ['name', 'email', 'password'];
}
