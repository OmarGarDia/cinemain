<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PeliculasController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DirectorController;
use App\Http\Controllers\ActoresController;
use App\Http\Controllers\SeriesController;


use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth', 'checkRole:1'])->group(function () {
    // Rutas protegidas por 'auth' y 'checkAdminRole'
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Rutas solo protegidas por 'auth'
    Route::get('/users', [UserController::class, 'index'])->name('usuarios');
    Route::get('/users/editar/{id}', [UserController::class, 'edit'])->name('users.edit');
    Route::post('/users/update/{id}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/delete/{id}', [UserController::class, 'destroy'])->name('users.delete');
    Route::get('/perfil/{userId}/info', [UserController::class, 'userinfo'])->name('perfil.info');

    Route::get('/peliculas', [PeliculasController::class, 'index'])->name('peliculas');
    Route::get('/peliculas/add', [PeliculasController::class, 'create'])->name('addmovie');
    Route::post('/peliculas/addmovie', [PeliculasController::class, 'store'])->name('storemovie');
    Route::get('/peliculas/editar/{id}', [PeliculasController::class, 'edit'])->name('editarmovie');
    Route::post('/peliculas/editarmovie/{id}', [PeliculasController::class, 'update'])->name('updatemovie');
    Route::delete('/peliculas/delete/{id}', [PeliculasController::class, 'destroy'])->name('deletemovie');
    Route::get('/peliculas/{movieId}/info', [PeliculasController::class, 'movieinfo'])->name('movieinfo');
    Route::post('/searchmovie', [PeliculasController::class, 'search'])->name('searchmovie');

    Route::get('/directores', [DirectorController::class, 'index'])->name('directores');
    Route::get('/directores/create', [DirectorController::class, 'create'])->name('createdirector');
    Route::post('/directores/adddirector', [DirectorController::class, 'store'])->name('storedirector');
    Route::get('/directores/editar/{id}', [DirectorController::class, 'edit'])->name('editdirector');
    Route::post('/directores/editardirector/{id}', [DirectorController::class, 'update'])->name('updatedirector');
    Route::delete('/directores/delete/{id}', [DirectorController::class, 'destroy'])->name('deletedirector');
    Route::get('/directores/{id}', [DirectorController::class, 'show'])->name('infodirector');
    Route::post('/search/director', [DirectorController::class, 'search'])->name('search.director');

    Route::get('/actores', [ActoresController::class, 'index'])->name('actores');
    Route::get('/actores/add', [ActoresController::class, 'create'])->name('createactor');
    Route::post('/actores/addactor', [ActoresController::class, 'store'])->name('storeactor');
    Route::get('/actores/editar/{id}', [ActoresController::class, 'edit'])->name('editactor');
    Route::post('actores/editaractor/{id}', [ActoresController::class, 'update'])->name('updateactor');
    Route::delete('/actores/delete/{id}', [ActoresController::class, 'destroy'])->name('deleteactor');
    Route::get('/actores/{id}', [ActoresController::class, 'show'])->name('infoactor');

    Route::get('/series', [SeriesController::class, 'index'])->name('series');
    Route::get('/series/create', [SeriesController::class, 'create'])->name('createserie');
    Route::post('/series/add', [SeriesController::class, 'store'])->name('storeserie');
    Route::get('/series/{serieId}/info', [SeriesController::class, 'serieinfo'])->name('serieinfo');

    Route::post('/search-series', [SeriesController::class, 'search'])->name('your_series_search_route');
});


require __DIR__ . '/auth.php';
