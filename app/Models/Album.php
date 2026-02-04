<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Album extends Model
{
    use HasFactory;

    protected $table = 'album';

    // 1. Adicionado 'capa_path' ao fillable para permitir o salvamento do caminho do MinIO
    protected $fillable = [
        'artista_id', 
        'alb_titulo', 
        'alb_data_lancamento', 
        'alb_status', 
        'capa_path'
    ];

    protected $casts = [
        'alb_status' => 'boolean',
        'alb_data_lancamento' => 'date',
    ];

    // 2. Faz com que o 'foto_url' apareça automaticamente quando você transformar o Model em JSON/Array (API)
    protected $appends = ['foto_url'];

    /**
     * Accessor para retornar a URL completa da foto vinda do MinIO.
     */
    protected function fotoUrl(): Attribute
    {
        return Attribute::get(function () {
            if (!$this->capa_path) {
                return null; 
            }
            
            return Storage::disk('s3')->url($this->capa_path);
        });
    }

    public function artista()
    {
        return $this->belongsTo(Artista::class, 'artista_id');
    }

    /**
     * Se você ainda for usar a tabela separada de fotos (galeria), mantenha este:
     */
    public function foto()
    {
        return $this->hasMany(FotoAlbum::class);
    }
}