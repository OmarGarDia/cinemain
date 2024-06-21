<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PeliculasController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DirectorController;

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

    Route::get('/directores', [DirectorController::class, 'index'])->name('directores');
    Route::get('/directores/create', [DirectorController::class, 'create'])->name('createdirector');
    Route::post('/directores/adddirector', [DirectorController::class, 'store'])->name('storedirector');
    Route::get('/directores/{id}', [DirectorController::class, 'show'])->name('infodirector');
});


require __DIR__ . '/auth.php';
