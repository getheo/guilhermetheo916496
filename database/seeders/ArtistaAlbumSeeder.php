<?php

namespace Database\Seeders;

use App\Models\ArtistaAlbum;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ArtistaAlbumSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Artista 1 - Album 1 a 3
        if (!ArtistaAlbum::where(['artista_id' => 1, 'album_id' => 1])->first()) {
            ArtistaAlbum::create([
                'artista_id' => 1,
                'album_id' => 1,
            ]);
        }
        if (!ArtistaAlbum::where(['artista_id' => 1, 'album_id' => 2])->first()) {
            ArtistaAlbum::create([
                'artista_id' => 1,
                'album_id' => 2,
            ]);
        }
        if (!ArtistaAlbum::where(['artista_id' => 1, 'album_id' => 3])->first()) {
            ArtistaAlbum::create([
                'artista_id' => 1,
                'album_id' => 3,
            ]);
        }
        

        // Artista 2 - Album 4 a 7
        if (!ArtistaAlbum::where(['artista_id' => 2, 'album_id' => 4])->first()) {
            ArtistaAlbum::create([
                'artista_id' => 2,
                'album_id' => 4,
            ]);
        }
        if (!ArtistaAlbum::where(['artista_id' => 2, 'album_id' => 5])->first()) {
            ArtistaAlbum::create([
                'artista_id' => 2,
                'album_id' => 5,
            ]);
        }
        if (!ArtistaAlbum::where(['artista_id' => 2, 'album_id' => 6])->first()) {
            ArtistaAlbum::create([
                'artista_id' => 2,
                'album_id' => 6,
            ]);
        }
        if (!ArtistaAlbum::where(['artista_id' => 2, 'album_id' => 7])->first()) {
            ArtistaAlbum::create([
                'artista_id' => 2,
                'album_id' => 7,
            ]);
        }

        // Artista 3 - Album 8 a 12
        if (!ArtistaAlbum::where(['artista_id' => 3, 'album_id' => 8])->first()) {
            ArtistaAlbum::create([
                'artista_id' => 3,
                'album_id' => 8,
            ]);
        }
        if (!ArtistaAlbum::where(['artista_id' => 3, 'album_id' => 9])->first()) {
            ArtistaAlbum::create([
                'artista_id' => 3,
                'album_id' => 9,
            ]);
        }
        if (!ArtistaAlbum::where(['artista_id' => 3, 'album_id' => 10])->first()) {
            ArtistaAlbum::create([
                'artista_id' => 3,
                'album_id' => 10,
            ]);
        }

        // Artista 4 - Album 11 a 13
        if (!ArtistaAlbum::where(['artista_id' => 4, 'album_id' => 11])->first()) {
            ArtistaAlbum::create([
                'artista_id' => 4,
                'album_id' => 11,
            ]);
        }        
        if (!ArtistaAlbum::where(['artista_id' => 4, 'album_id' => 12])->first()) {
            ArtistaAlbum::create([
                'artista_id' => 4,
                'album_id' => 12,
            ]);
        }
        if (!ArtistaAlbum::where(['artista_id' => 4, 'album_id' => 13])->first()) {
            ArtistaAlbum::create([
                'artista_id' => 4,
                'album_id' => 13,
            ]);
        }
    }
}
