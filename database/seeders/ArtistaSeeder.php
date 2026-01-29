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
        if (!Artista::where('id', 1)->first()) {
            Artista::create([                                
                'art_nome' => 'Serj Tankian',                
            ]);
        }

        if (!Artista::where('id', 2)->first()) {
            Artista::create([                                
                'art_nome' => 'Mike Shinoda',                
            ]);
        }

        if (!Artista::where('id', 3)->first()) {
            Artista::create([                                
                'art_nome' => 'Michel Teló',                
            ]);
        }

        if (!Artista::where('id', 4)->first()) {
            Artista::create([                                
                'art_nome' => 'Guns N Roses',                
            ]);
        }

        if (!Artista::where('id', 5)->first()) {
            Artista::create([                                
                'art_nome' => 'Henrique e Juliano',                
            ]);
        }

        if (!Artista::where('id', 6)->first()) {
            Artista::create([                                
                'art_nome' => 'Alceu Valença',                
            ]);
        }

        if (!Artista::where('id', 7)->first()) {
            Artista::create([                                
                'art_nome' => 'Roberto Carlos',                
            ]);
        }

        if (!Artista::where('id', 8)->first()) {
            Artista::create([                                
                'art_nome' => 'Banda Scort Som',                
            ]);
        }

        if (!Artista::where('id', 9)->first()) {
            Artista::create([                                
                'art_nome' => 'Lucianinho dos Teclados',                
            ]);
        }

        if (!Artista::where('id', 10)->first()) {
            Artista::create([                                
                'art_nome' => 'Banda Novo Som',                
            ]);
        }

        Artista::factory()->count(10)->create();
        
    }
}
