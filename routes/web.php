<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::apiResource('artistas', App\Http\Controllers\ArtistaController::class);

Route::fallback(function(){
    return response()->json([
        'message' => 'Endpoint não encontrado. Por favor confira a documentação da API para verificar os endpoints.'
    ], 404);
});