<?php

namespace Database\Seeders;

use App\Models\Musica;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MusicaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (!Musica::where(['album_id' => 1, 'mus_titulo' => 'Cavaleiro Andante'])->first()) {
            Musica::create([                                
                'album_id' => 1,
                'mus_titulo' => 'Cavaleiro Andante',
            ]);
        }

        if (!Musica::where(['album_id' => 1, 'mus_titulo' => 'Cavaleiro Andante 2'])->first()) {
            Musica::create([                                
                'album_id' => 1,
                'mus_titulo' => 'Cavaleiro Andante 2',
            ]);
        }

        if (!Musica::where(['album_id' => 2, 'mus_titulo' => 'Nossa musica'])->first()) {
            Musica::create([                                
                'album_id' => 2,
                'mus_titulo' => 'Nossa musica',
            ]);
        }       
        
    }
}
