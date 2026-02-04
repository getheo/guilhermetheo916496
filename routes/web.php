<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Artista\Manage as ArtistaManage;
use App\Livewire\Album\Manage as AlbumManage;
use App\Livewire\Musica\Manage as MusicaManage;

Route::view('/', 'welcome');

// Rotas protegidas por autenticação
Route::middleware(['auth', 'verified'])->group(function () {
    
    Route::get('/dashboard', function () {
        return view('dashboard', [
            'totalArtistas' => \App\Models\Artista::count(),
            'totalAlbuns' => \App\Models\Album::count(),
            'totalMusicas' => \App\Models\Musica::count(),
        ]);
    })->middleware(['auth', 'verified'])->name('dashboard');

    // Gerenciamento do Ecossistema Musical
    Route::prefix('dashboard')->group(function () {
        Route::get('/artistas', ArtistaManage::class)->name('artistas.index');
        Route::get('/albuns', AlbumManage::class)->name('albuns.index');
        Route::get('/musicas', MusicaManage::class)->name('musicas.index');
    });

    Route::get('/artistas', ArtistaManage::class)->name('artistas.index');
    Route::get('/albuns', AlbumManage::class)->name('albuns.index');
    Route::get('/musicas', MusicaManage::class)->name('musicas.index');

    // Perfil do Usuário
    Route::view('profile', 'profile')->name('profile');
});

require __DIR__.'/auth.php';