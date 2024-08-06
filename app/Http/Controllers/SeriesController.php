<?php

namespace App\Http\Controllers;

use App\Services\SerieService;

use App\Http\Requests\UpdateSerieRequest;
use App\Http\Requests\StoreSerieRequest;
use App\Models\Actor;
use Illuminate\Http\Request;
use App\Models\Serie;
use App\Models\Director;
use App\Models\Genre;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

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
    public function store(StoreSerieRequest $request)
    {
        $datos = $request->all();
        $datos['imagen_serie'] = $request->file('imagen_serie');

        $this->serieService->storeSerie($datos);

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
    public function destroy(Serie $serie)
    {
        if ($serie->imagen && Storage::exists('public/series/' . $serie->imagen)) {
            Storage::delete('public/series/' . $serie->imagen);
        }
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

    public function toAddElenco(Serie $serieId)
    {
        $actores = Actor::all();
        return view('series.addactors', compact('serieId', 'actores'));
    }

    public function storeActorToSerie(Request $request, int $id)
    {
        $request->validate([
            'actor_ids' => 'required|array',
            'actor_ids.*' => 'exists:actors,id',
        ]);

        $serie = Serie::findOrFail($id);

        $actor_ids = $request->actor_ids;

        foreach ($actor_ids as $actor_id) {
            $serie->actores()->attach($actor_id, [
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }

        return redirect()->route('serieinfo', $serie->id)->with('success', 'Actores añadidos correctamente');
    }

    public function deleteActorFromSerie(Serie $serie, Actor $actor)
    {
        $serie->actores()->detach($actor->id);

        return redirect()->back()->with('success', 'Actor eliminado de la serie correctamente.');
    }
}
