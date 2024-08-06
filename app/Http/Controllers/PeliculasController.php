<?php

namespace App\Http\Controllers;

use App\Models\Pelicula;
use App\Models\Director;
use App\Models\Genre;
use App\Models\Actor;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;


class PeliculasController extends Controller
{

    public function index()
    {
        $peliculas = Pelicula::with('director', 'genres')->paginate(10);

        foreach ($peliculas as $pelicula) {
            $pelicula->genres_array = $pelicula->genres->pluck('name')->toArray();
        }

        return view('movies.movie', compact('peliculas'));
    }

    public function create()
    {
        $directores = Director::all();
        $generos = Genre::all();
        return view('movies.add', compact('directores', 'generos'));
    }

    public function edit(int $id)
    {
        $directores = Director::all();
        $peliculas = Pelicula::findOrFail($id);
        $generos = Genre::all(); // Obtener todos los géneros disponibles

        $generosSeleccionados = $peliculas->genres()->pluck('genres.id')->toArray();

        return view('movies.editar', compact('peliculas', 'generos', 'generosSeleccionados', 'directores'));
    }

    public function movieinfo($movieId)
    {
        $movie = Pelicula::with('director', 'actores', 'genres')->findOrFail($movieId);


        $generos = $movie->genres;
        $actorNames = $movie->actores->pluck('nombre')->toArray();
        $actoresString = implode(', ', $actorNames);

        return view('movies.info', compact('movie', 'generos', 'actoresString'));
    }

    public function update(Request $request, Pelicula $pelicula)
    {
        try {
            $request->validate([
                'titulo' => 'required|string|max:255|unique:peliculas,titulo,' . $pelicula->id,
                'anio' => 'required|integer',
                'sinopsis' => 'required|string',
                'duracion' => 'required|integer',
                'idioma' => 'required|string|max:255',
                'pais' => 'required|string|max:255',
                'generos' => 'required|array',
                'generos.*' => 'exists:genres,id',
                'calificacion' => 'required|numeric|min:1|max:10',
                'fecha_estreno' => 'required|date',
                'imagen_pelicula' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
            ], [
                'titulo.unique' => 'Ya existe una pelicula con ese titulo',
            ]);

            $pelicula->titulo = $request->titulo;
            $pelicula->año = $request->anio;
            $pelicula->sinopsis = $request->sinopsis;
            $pelicula->duracion = $request->duracion;
            $pelicula->idioma = $request->idioma;
            $pelicula->pais = $request->pais;
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

            // Actualiza los géneros
            $pelicula->genres()->sync($request->generos);

            $pelicula->save();

            return redirect()->route('peliculas')->with('success', 'Pelicula actualizada correctamente');
        } catch (ValidationException $e) {
            // Aquí se ejecuta si la validación falla
            $errors = $e->validator->errors()->all();
            return redirect()->back()->withErrors($errors)->withInput();
        }
    }


    public function destroy(Pelicula $pelicula)
    {
        if ($pelicula->imagen && Storage::exists('public/movies/' . $pelicula->imagen)) {
            Storage::delete('public/movies/' . $pelicula->imagen);
        }

        $pelicula->delete();
        return redirect()->route('peliculas')->with('success', 'Pelicula eliminada correctamente.');
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
            'calificacion' => 'required|numeric|min:1|max:10',
            'fecha_estreno' => 'required|date',
            'director_id' => 'required|exists:directors,id',
            'imagen_pelicula' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'generos' => 'required|array',
            'generos.*' => 'exists:genres,id'
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
        $pelicula->calificacion = $request->calificacion;
        $pelicula->fecha_estreno = $request->fecha_estreno;
        $pelicula->director_id = $request->director_id;

        $file = $request->file('imagen_pelicula');
        if ($file) {
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $filePath = $file->storeAs('movies', $filename, 'public');
            $pelicula->imagen = $filename;
        } else {
            return back()->withErrors(['imagen' => 'El archivo de imagen no se ha cargado correctamente.']);
        }

        $pelicula->save();
        $pelicula->genres()->sync($request->generos);

        return redirect()->route('peliculas')->with('success', 'Pelicula almacenada correctamente');
    }

    public function toAddElenco(Pelicula $movieId)
    {
        $actores = Actor::all();
        $pelicula = $movieId;
        return view('movies.addactors', compact('pelicula', 'actores'));
    }

    public function storeActorToMovie(Request $request, int $id)
    {
        $request->validate([
            'actor_ids' => 'required|array',
            'actor_ids.*' => 'exists:actors,id',
        ]);

        $movie = Pelicula::findOrFail($id);

        $actor_ids = $request->actor_ids;

        foreach ($actor_ids as $actor_id) {
            $movie->actores()->attach($actor_id, [
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }

        return redirect()->route('movieinfo', $movie->id)->with('success', 'Actores añadidos correctamente');
    }

    public function deleteActorFromMovie(Pelicula $pelicula, Actor $actor)
    {
        $pelicula->actores()->detach($actor->id);

        return redirect()->back()->with('success', 'Actor eliminado de la pelicula correctamente.');
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $apiKey = env('TMDB_API_KEY'); // Asegúrate de tener tu clave de API en tu archivo .env

        $response = Http::get("https://api.themoviedb.org/3/search/movie", [
            'api_key' => $apiKey,
            'query' => $query,
            'language' => 'es-ES',
            'include_adult' => false
        ]);

        $results = $response->json()['results'];

        // Si necesitas más detalles de cada película, puedes hacer una solicitud adicional para cada película
        $detailedResults = [];

        foreach ($results as $movie) {
            $movieId = $movie['id'];
            $movieDetailsResponse = Http::get("https://api.themoviedb.org/3/movie/{$movieId}", [
                'api_key' => $apiKey,
                'language' => 'es-ES'
            ]);

            $detailedResults[] = $movieDetailsResponse->json();
        }

        return response()->json(['results' => $detailedResults]);
    }

    public function mostrarPeliculas()
    {

        $peliculas = Pelicula::all();
        return view('users.peliculas', compact('peliculas'));
    }

    public function filtrarPorGenero($generoId)
    {
        $peliculas = Pelicula::whereHas('genres', function ($query) use ($generoId) {
            $query->where('genres.id', $generoId);
        })->get();

        return view('movies.filtroGenero', compact('peliculas'));
    }
}
