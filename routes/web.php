<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PeliculasController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DirectorController;
use App\Http\Controllers\ActoresController;
use App\Http\Controllers\SeriesController;
use App\Http\Controllers\SeasonsController;
use App\Http\Controllers\EpisodesController;
use App\Http\Controllers\BasicUserController;


use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'checkRole:1'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Rutas protegidas por 'auth' y 'checkAdminRole'
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Rutas solo protegidas por 'auth'
    Route::get('/users', [UserController::class, 'index'])->name('usuarios');
    Route::get('/users/editar/{user}', [UserController::class, 'edit'])->name('users.edit');
    Route::post('/users/update/{id}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/delete/{user}', [UserController::class, 'destroy'])->name('users.delete');
    Route::get('/perfil/{userId}/info', [UserController::class, 'userinfo'])->name('perfil.info');

    Route::get('/listapeliculas', [PeliculasController::class, 'index'])->name('peliculas');
    Route::get('/peliculas/add', [PeliculasController::class, 'create'])->name('addmovie');
    Route::post('/peliculas/addmovie', [PeliculasController::class, 'store'])->name('storemovie');
    Route::get('/peliculas/editar/{id}', [PeliculasController::class, 'edit'])->name('editarmovie');
    Route::post('/peliculas/editarmovie/{id}', [PeliculasController::class, 'update'])->name('updatemovie');
    Route::delete('/peliculas/delete/{pelicula}', [PeliculasController::class, 'destroy'])->name('deletemovie');
    Route::get('/peliculas/{movieId}/info', [PeliculasController::class, 'movieinfo'])->name('movieinfo');
    Route::get('/peliculas/{movieId}/elenco', [PeliculasController::class, 'toAddElenco'])->name('movieelenco');
    Route::post('/movies/{id}/addactors', [PeliculasController::class, 'storeActorToMovie'])->name('store_actor_to_movie');
    Route::get('/peliculas/genero/{genero}', [PeliculasController::class, 'filtrarPorGenero'])->name('peliculas.genero');
    Route::post('/searchmovie', [PeliculasController::class, 'search'])->name('searchmovie');


    //  ============= DIRECTORES =============

    Route::get('/directores', [DirectorController::class, 'index'])->name('directores');
    Route::get('/directores/create', [DirectorController::class, 'create'])->name('createdirector');
    Route::post('/directores/adddirector', [DirectorController::class, 'store'])->name('storedirector');
    Route::get('/directores/editar/{director}', [DirectorController::class, 'edit'])->name('editdirector');
    Route::post('/directores/editardirector/{director}', [DirectorController::class, 'update'])->name('updatedirector');
    Route::delete('/directores/delete/{director}', [DirectorController::class, 'destroy'])->name('deletedirector');
    Route::get('/directores/{director}', [DirectorController::class, 'show'])->name('infodirector');
    Route::post('/search/director', [DirectorController::class, 'search'])->name('search.director');


    //  ============= ACTORES =============

    Route::get('/actores', [ActoresController::class, 'index'])->name('actores');
    Route::get('/actores/add', [ActoresController::class, 'create'])->name('createactor');
    Route::post('/actores/addactor', [ActoresController::class, 'store'])->name('storeactor');
    Route::get('/actores/editar/{actor}', [ActoresController::class, 'edit'])->name('editactor');
    Route::post('actores/editaractor/{actor}', [ActoresController::class, 'update'])->name('updateactor');
    Route::delete('/actores/delete/{actor}', [ActoresController::class, 'destroy'])->name('deleteactor');
    Route::get('/actores/{actor}', [ActoresController::class, 'show'])->name('infoactor');


    //  ============= SERIES =============

    Route::get('/series', [SeriesController::class, 'index'])->name('series');
    Route::get('/series/create', [SeriesController::class, 'create'])->name('createserie');
    Route::post('/series/add', [SeriesController::class, 'store'])->name('storeserie');
    Route::get('/series/editar/{id}', [SeriesController::class, 'edit'])->name('editarserie');
    Route::post('series/editarserie/{id}', [SeriesController::class, 'update'])->name('updateserie');
    Route::delete('/series/delete/{id}', [SeriesController::class, 'destroy'])->name('deleteserie');
    Route::get('/series/{serieId}/info', [SeriesController::class, 'serieinfo'])->name('serieinfo');
    Route::get('/series/{serieId}/elenco', [SeriesController::class, 'toAddElenco'])->name('elenco');
    Route::post('/series/{id}/addactors', [SeriesController::class, 'storeActorToSerie'])->name('store_actor_to_serie');

    //  ============= TEMPORADAS =============

    Route::get('/series/temporadas/{id}', [SeasonsController::class, 'index'])->name('seasons');
    Route::post('/series/{id}/temporadas/add', [SeasonsController::class, 'store'])->name('storeseasons');
    Route::get('/series/temporadas/{idSerie}/info/{idTemp}', [SeasonsController::class, 'temporadainfo'])->name('temporadainfo');
    Route::post('/series/temporadas/{temporada}', [SeasonsController::class, 'destroy'])->name('deleteseason');


    //  ============= EPISODIOS =============

    Route::get('/series/{idSerie}/temporadas/{idTemp}/episodes', [EpisodesController::class, 'index'])->name('episodes');
    Route::get('/series/{idSerie}/temporadas/{idTemp}/episodes/add', [EpisodesController::class, 'create'])->name('addepisode');
    Route::delete('/series/capitulos/{id}', [EpisodesController::class, 'destroy'])->name('destroyepisode');
    Route::post('/series/{idSerie}/temporadas/{idTemp}/episodes/store', [EpisodesController::class, 'store'])->name('storeepisode');
    Route::get('/episode/{episodio}', [EpisodesController::class, 'show'])->name('episodeinfo');

    Route::post('/search-series', [SeriesController::class, 'search'])->name('your_series_search_route');
});

Route::middleware(['auth', 'checkRole:2'])->group(function () {
    Route::get('/index', [BasicUserController::class, 'index'])->name('index');

    Route::get('/peliculas', [PeliculasController::class, 'mostrarPeliculas'])->name('peliculasUsuario');
});


require __DIR__ . '/auth.php';
