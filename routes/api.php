<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ArtistaController;
use App\Http\Controllers\AlbumController;
use App\Http\Controllers\MusicaController;
use App\Http\Controllers\FotoAlbumController;

use App\Http\Controllers\FileController;
use App\Http\Controllers\FotoArtistaController;
use App\Http\Controllers\RegionalController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user(); 
    Route::apiResource('albums', [PessoaController::class, 'index']);
});
*/

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    //Route::apiResource('albums', PessoaController::class);

    Route::post('/logout', [AuthController::class, 'logout']);    
    Route::post('/refresh', [AuthController::class, 'refresh']);

    /* Rotas para os Artistas */
    Route::get('artista', [ArtistaController::class, 'index']);
    Route::post('artista', [ArtistaController::class, 'store']);
    Route::get('artista/{id}', [ArtistaController::class, 'show']);
    Route::put('artista/{id}', [ArtistaController::class, 'update']);
    Route::delete('artista/{id}', [ArtistaController::class, 'destroy']);

    /* Rotas para os Albuns */
    Route::get('album', [AlbumController::class, 'index']);
    Route::post('album', [AlbumController::class, 'store']);
    Route::get('album/{id}', [AlbumController::class, 'show']);
    Route::put('album/{id}', [AlbumController::class, 'update']);
    Route::delete('album/{id}', [AlbumController::class, 'destroy']);

    /* Rotas para as Musicas */
    Route::get('musica', [MusicaController::class, 'index']);
    Route::post('musica', [MusicaController::class, 'store']);
    Route::get('musica/{id}', [MusicaController::class, 'show']);
    Route::put('musica/{id}', [MusicaController::class, 'update']);
    Route::delete('musica/{id}', [MusicaController::class, 'destroy']);

    /* Rotas para os Foto Albuns */
    //Route::get('foto-album', [FotoAlbumController::class, 'index']);    
    Route::post('foto-album', [FotoAlbumController::class, 'upload']);

    /* Rotas para os Foto Artistas */
    Route::post('foto-artista', [FotoArtistaController::class, 'upload']);
    //Route::post('foto-pessoa', [FileController::class, 'store']);

    /* Rotas para os Regionais */
    Route::get('regional', [RegionalController::class, 'index']);

});



