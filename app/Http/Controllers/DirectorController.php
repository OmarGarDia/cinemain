<?php

namespace App\Http\Controllers;

use App\Models\Director;
use Illuminate\Http\Request;

class DirectorController extends Controller
{

    public function index()
    {
        $directores = Director::all();
        return view('directors.directores', compact('directores'));
    }

    public function show($id)
    {
        $director = Director::findOrFail($id);
        $peliculas = $director->peliculas()->paginate(12);
        $numPeliculas = $director->peliculas->count();

        return view('directors.info', compact('director', 'peliculas', 'numPeliculas'));
    }
}
