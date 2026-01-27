<?php

namespace Database\Seeders;

use App\Models\Artista;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ArtistaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (!Artista::where('art_nome', 'Serj Tankian')->first()) {
            Artista::create([                                
                'art_nome' => 'Serj Tankian',                
            ]);
        }

        if (!Artista::where('art_nome', 'Mike Shinoda')->first()) {
            Artista::create([                                
                'art_nome' => 'Mike Shinoda',                
            ]);
        }

        if (!Artista::where('art_nome', 'Michel Teló')->first()) {
            Artista::create([                                
                'art_nome' => 'Michel Teló',                
            ]);
        }

        if (!Artista::where('art_nome', 'Guns N Roses')->first()) {
            Artista::create([                                
                'art_nome' => 'Guns N Roses',                
            ]);
        }

        if (!Artista::where('art_nome', 'Henrique e Juliano')->first()) {
            Artista::create([                                
                'art_nome' => 'Henrique e Juliano',                
            ]);
        }

        if (!Artista::where('art_nome', 'Alceu Valença')->first()) {
            Artista::create([                                
                'art_nome' => 'Alceu Valença',                
            ]);
        }

        if (!Artista::where('art_nome', 'Roberto Carlos')->first()) {
            Artista::create([                                
                'art_nome' => 'Roberto Carlos',                
            ]);
        }

        if (!Artista::where('art_nome', 'Banda Scort Som')->first()) {
            Artista::create([                                
                'art_nome' => 'Banda Scort Som',                
            ]);
        }

        if (!Artista::where('art_nome', 'Lucianinho dos Teclados')->first()) {
            Artista::create([                                
                'art_nome' => 'Lucianinho dos Teclados',                
            ]);
        }

        if (!Artista::where('art_nome', 'Banda Novo Som')->first()) {
            Artista::create([                                
                'art_nome' => 'Banda Novo Som',                
            ]);
        }
        
    }
}
