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

    public function edit(int $id)
    {
        $peliculas = Pelicula::findOrFail($id);
        return view('movies.editar', compact('peliculas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255|unique:peliculas,titulo',
            'anio' => 'required|integer',
            'sinopsis' => 'required|string',
            'duracion' => 'required|integer',
            'idioma' => 'required|string|max:255',
            'pais' => 'required|string|max:255',
            'genero' => 'required|string|max:255',
            'calificacion' => 'required|integer|min:1|max:10',
            'fecha_estreno' => 'required|date',
            'imagen_pelicula' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ], [
            'titulo.unique' => 'Ya existe una pelicula con ese titulo',
        ]);

        $pelicula = new Pelicula();
        $pelicula->titulo = $request->titulo;
        $pelicula->año = $request->anio;
        $pelicula->sinopsis = $request->sinopsis;
        $pelicula->duracion = $request->duracion;
        $pelicula->idioma = $request->idioma;
        $pelicula->pais = $request->pais;
        $pelicula->genero = $request->genero;
        $pelicula->calificacion = $request->calificacion;
        $pelicula->fecha_estreno = $request->fecha_estreno;

        $file = $request->file('imagen_pelicula');
        if ($file) {
            $file = $request->file('imagen_pelicula');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $filePath = $file->storeAs('movies', $filename, 'public');
            $pelicula->imagen = $filename;
        } else {
            return back()->withErrors(['imagen' => 'El archivo de imagen no se ha cargado correctamente.']);
        }

        $pelicula->save();

        return redirect()->route('peliculas')->with('success', 'Pelicula almacenada correctamente');
    }
}
