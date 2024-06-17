<?php

namespace App\Http\Controllers;

use App\Models\Pelicula;
use Illuminate\Http\Request;

class PeliculasController extends Controller
{

    public function index()
    {
        $peliculas = Pelicula::all();
        return view('movies.movie', compact('peliculas'));
    }

    public function create()
    {
        return view('movies.add');
    }

    public function store(Request $request)
    {
    }
}
