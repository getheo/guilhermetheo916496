<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Artista\Manage as ArtistaManage;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

// Coloque dentro do grupo de autenticação para proteger a página
Route::middleware(['auth', 'verified'])->group(function () {
    
    Route::get('/dashboard/artistas', ArtistaManage::class)->name('artistas.manage');

});

require __DIR__.'/auth.php';
