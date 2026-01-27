<?php

namespace Database\Seeders;

use App\Models\Album;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AlbumSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Artista 1        
        if (!Album::where(['artista_id' => 1, 'titulo' => 'Harakiri'])->first()) {
            Album::create([
                'artista_id' => 1,
                'titulo' => 'Harakiri',
            ]);
        }
        if (!Album::where(['artista_id' => 1, 'titulo' => 'Black Blooms'])->first()) {
            Album::create([
                'artista_id' => 1,
                'titulo' => 'Black Blooms',
            ]);
        }
        if (!Album::where(['artista_id' => 1, 'titulo' => '“The Rough Dog'])->first()) {
            Album::create([
                'artista_id' => 1,
                'titulo' => '“The Rough Dog',
            ]);
        }

        // Artista 2
        if (!Album::where(['artista_id' => 2, 'titulo' => 'The Rising Tied'])->first()) {
            Album::create([
                'artista_id' => 2,
                'titulo' => 'The Rising Tied',
            ]);
        }
        if (!Album::where(['artista_id' => 2, 'titulo' => 'Post Traumatic'])->first()) {
            Album::create([
                'artista_id' => 2,
                'titulo' => 'Post Traumatic',
            ]);
        }
        if (!Album::where(['artista_id' => 2, 'titulo' => 'Post Traumatic EP'])->first()) {
            Album::create([
                'artista_id' => 2,
                'titulo' => 'Post Traumatic EP',
            ]);
        }
        if (!Album::where(['artista_id' => 2, 'titulo' => 'Whered You Go'])->first()) {
            Album::create([
                'artista_id' => 2,
                'titulo' => 'Whered You Go',
            ]);
        }

        // Artista 3
        if (!Album::where(['artista_id' => 3, 'titulo' => 'Bem Sertanejo'])->first()) {
            Album::create([
                'artista_id' => 3,
                'titulo' => 'Bem Sertanejo',
            ]);
        }
        if (!Album::where(['artista_id' => 3, 'titulo' => 'Bem Sertanejo - O Show (Ao Vivo)'])->first()) {
            Album::create([
                'artista_id' => 3,
                'titulo' => 'Bem Sertanejo - O Show (Ao Vivo)',
            ]);
        }
        if (!Album::where(['artista_id' => 3, 'titulo' => 'Bem Sertanejo - (1ª Temporada) - EP'])->first()) {
            Album::create([
                'artista_id' => 3,
                'titulo' => 'Bem Sertanejo - (1ª Temporada) - EP',
            ]);
        }

        // Artista 4
        if (!Album::where(['artista_id' => 4, 'titulo' => 'Use Your Illusion I'])->first()) {
            Album::create([
                'artista_id' => 4,
                'titulo' => 'Use Your Illusion I',
            ]);
        }
        if (!Album::where(['artista_id' => 4, 'titulo' => 'Use Your Illusion II'])->first()) {
            Album::create([
                'artista_id' => 4,
                'titulo' => 'Use Your Illusion II',
            ]);
        }
        if (!Album::where(['artista_id' => 4, 'titulo' => 'Greatest Hits'])->first()) {
            Album::create([
                'artista_id' => 4,
                'titulo' => 'Greatest Hits',
            ]);
        }

    }
}
