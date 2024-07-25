<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateSerieRequest;
use Illuminate\Http\Request;
use App\Models\Serie;
use App\Models\Director;
use App\Models\Genre;

use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;
use App\Http\Services\SerieService;

class SeriesController extends Controller
{
    protected $serieService;
    /**
     * Display a listing of the resource.
     */
    public function __construct(SerieService $serieService)
    {
        $this->serieService = $serieService;
    }

    public function index()
    {
        $series = Serie::with('director')
            ->withCount('seasons')
            ->get()
            ->map(function ($serie) {
                $serie->load('genres');
                $serie->genres_array = $serie->genres->pluck('name')->toArray();
                return $serie;
            });

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
        $generos = Genre::all();
        return view('series.add', compact('directores', 'generos'));
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
            'generos' => 'required|array', // Asegúrate de que los géneros estén presentes y sean un arreglo
            'generos.*' => 'exists:genres,id', // Valida que cada género exista en la tabla de géneros por su id
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

        $serie->genres()->attach($request->generos);
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
    public function update(UpdateSerieRequest $request, string $id)
    {
        try {
            $serie = Serie::findOrFail($id);
            $datosActualizados = $request->validated(); // Usa validated() en lugar de validate()

            $this->serieService->updateSerie($serie, $datosActualizados);
            return redirect()->route('series')->with('success', 'Serie actualizada correctamente');
        } catch (ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $serie = Serie::findOrFail($id);
        $serie->delete();
        return redirect()->route('series')->with('success', 'Serie eliminada correctamente.');
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
