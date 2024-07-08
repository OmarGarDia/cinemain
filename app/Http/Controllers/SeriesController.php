<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Serie;
use App\Models\Director;
use App\Models\Genre;

use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Storage;


class SeriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $series = Serie::with('director')->get();
        return view('series.series', compact('series'));
    }

    public function serieinfo($id)
    {
        $serie = Serie::with('director', 'actores')->findOrFail($id);

        return view('series.info', compact('serie'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $directores = Director::all();
        return view('series.add', compact('directores'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required',
            'descripcion' => 'nullable',
            'fecha_estreno' => 'nullable|integer',
            'director_id' => 'nullable|exists:directors,id',
            'imagen_serie' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $nombreImagen = null;

        if ($request->hasFile('imagen_serie')) {
            $imagenPath = $request->file('imagen_serie')->store('public/series');
            $nombreImagen = basename($imagenPath);
        }

        $serie = Serie::create([
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'fecha_estreno' => $request->fecha_estreno,
            'director_id' => $request->director_id,
            'imagen' => $nombreImagen,
        ]);

        return redirect()->route('series')->with('success', 'Serie creada correctamente.');
    }


    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $directores = Director::all();
        $series = Serie::findOrFail($id);
        $generos = Genre::all();

        $generosSeleccionados = $series->genres()->pluck('genres.id')->toArray();

        return view('series.editar', compact('series', 'generos', 'generosSeleccionados', 'directores'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $request->validate([
                'titulo' => 'required|string|max:255|unique:series,titulo,' . $id,
                'fecha_estreno' => 'required|integer',
                'director_id' => 'nullable|exists:directors,id',
                'descripcion' => 'required|string',
                'imagen_serie' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
            ], [
                'titulo.unique' => 'Ya existe una serie con ese titulo',
            ]);

            $serie = Serie::findOrFail($id);
            $serie->titulo = $request->titulo;
            $serie->fecha_estreno = $request->fecha_estreno;
            $serie->descripcion = $request->descripcion;
            if ($request->hasFile('imagen_serie')) {
                if ($serie->imagen) {
                    Storage::delete('public/series/' . $serie->imagen);
                }

                $imagen = $request->file('imagen_serie');
                $nombreImagen = time() . '.' . $imagen->getClientOriginalExtension();
                $imagen->storeAs('public/series', $nombreImagen);
                $serie->imagen = $nombreImagen;
            }

            $serie->genres()->sync($request->generos);

            $serie->save();

            return redirect()->route('series')->with('success', 'Serie actualizada correctamente');
        } catch (ValidationException $e) {
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $apiKey = env('TMDB_API_KEY'); // Asegúrate de tener tu clave de API en tu archivo .env

        $response = Http::get("https://api.themoviedb.org/3/search/tv", [
            'api_key' => $apiKey,
            'query' => $query,
            'language' => 'es-ES',
        ]);

        $results = $response->json()['results'];

        // Si necesitas más detalles de cada serie, puedes hacer una solicitud adicional para cada serie
        $detailedResults = [];

        foreach ($results as $series) {
            $seriesId = $series['id'];
            $seriesDetailsResponse = Http::get("https://api.themoviedb.org/3/tv/{$seriesId}", [
                'api_key' => $apiKey,
                'language' => 'es-ES'
            ]);

            $detailedResults[] = $seriesDetailsResponse->json();
        }

        return response()->json(['results' => $detailedResults]);
    }
}
