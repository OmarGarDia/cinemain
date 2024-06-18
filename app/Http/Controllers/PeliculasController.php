<?php

namespace App\Http\Controllers;

use App\Models\Pelicula;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;


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

    public function update(Request $request, int $id)
    {

        try {
            $request->validate([
                'titulo' => 'required|string|max:255|unique:peliculas,titulo,' . $id,
                'anio' => 'required|integer',
                'sinopsis' => 'required|string',
                'duracion' => 'required|integer',
                'idioma' => 'required|string|max:255',
                'pais' => 'required|string|max:255',
                'genero' => 'required|string|max:255',
                'calificacion' => 'required|integer|min:1|max:10',
                'fecha_estreno' => 'required|date',
                'imagen_pelicula' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
            ], [
                'titulo.unique' => 'Ya existe una pelicula con ese titulo',
            ]);

            $pelicula = Pelicula::findOrFail($id);
            $pelicula->titulo = $request->titulo;
            $pelicula->año = $request->anio;
            $pelicula->sinopsis = $request->sinopsis;
            $pelicula->duracion = $request->duracion;
            $pelicula->idioma = $request->idioma;
            $pelicula->pais = $request->pais;
            $pelicula->genero = $request->genero;
            $pelicula->calificacion = $request->calificacion;
            $pelicula->fecha_estreno = $request->fecha_estreno;

            if ($request->hasFile('imagen_pelicula')) {
                if ($pelicula->imagen) {
                    Storage::delete('public/movies/' . $pelicula->imagen);
                }

                $imagen = $request->file('imagen_pelicula');
                $nombreImagen = time() . '.' . $imagen->getClientOriginalExtension();
                $imagen->storeAs('public/movies', $nombreImagen);
                $pelicula->imagen = $nombreImagen;
            }

            $pelicula->save();

            return redirect()->route('peliculas')->with('success', 'Pelicula actualizada correctamente');
        } catch (ValidationException $e) {
            // Aquí se ejecuta si la validación falla
            $errors = $e->validator->errors()->all();
            return redirect()->back()->withErrors($errors)->withInput();
        }
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
