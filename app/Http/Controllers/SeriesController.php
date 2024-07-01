<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Serie;
use App\Models\Director;
use Illuminate\Support\Facades\Http;


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
            'director' => 'nullable'
        ]);

        Serie::create($request->all());

        return redirect()->route('series')->with('success', 'Serie creada correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
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
