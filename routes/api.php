<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ArtistaController;
use App\Http\Controllers\AlbumController;
use App\Http\Controllers\MusicaController;
use App\Http\Controllers\FotoAlbumController;

use App\Http\Controllers\FileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user(); 
    Route::apiResource('albums', [PessoaController::class, 'index']);
});
*/

Route::post('/login', [AuthController::class, 'login']);
Route::post('/refresh', [AuthController::class, 'refresh']);

Route::middleware('auth:sanctum')->group(function () {
    //Route::apiResource('albums', PessoaController::class);

    Route::post('/logout', [AuthController::class, 'logout']);    

    /* Rotas para os Artistas */
    Route::get('artista', [ArtistaController::class, 'index']);
    Route::post('artista', [ArtistaController::class, 'store']);
    Route::get('artista/{art_id}', [ArtistaController::class, 'show']);
    Route::put('artista/{art_id}', [ArtistaController::class, 'update']);
    Route::delete('artista/{art_id}', [ArtistaController::class, 'destroy']);

    /* Rotas para os Albuns */
    Route::get('album', [AlbumController::class, 'index']);
    Route::post('album', [AlbumController::class, 'store']);
    Route::get('album/{alb_id}', [AlbumController::class, 'show']);
    Route::put('album/{alb_id}', [AlbumController::class, 'update']);
    Route::delete('album/{alb_id}', [AlbumController::class, 'destroy']);

    /* Rotas para as Musicas */
    Route::get('musica', [MusicaController::class, 'index']);
    Route::post('musica', [MusicaController::class, 'store']);
    Route::get('musica/{mus_id}', [MusicaController::class, 'show']);
    Route::put('musica/{mus_id}', [MusicaController::class, 'update']);
    Route::delete('musica/{mus_id}', [MusicaController::class, 'destroy']);

    /* Rotas para os Foto Albuns */
    //Route::get('foto-album', [FotoAlbumController::class, 'index']);
    
    Route::post('foto-album', [FotoAlbumController::class, 'upload']);
    //Route::post('foto-pessoa', [FileController::class, 'store']);

});



