<?php

namespace App\Http\Controllers;

use App\Models\Serie;
use App\Models\Season;
use App\Models\Episode;
use Illuminate\Http\Request;

class SeasonsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(int $id)
    {
        $serie = Serie::findOrFail($id);
        return view('seasons.seasons', compact('serie'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $id)
    {
        $request->validate([
            'seasons_count' => 'required|integer|min:1',
        ]);

        $seasonsCount = $request->seasons_count;

        for ($i = 1; $i <= $seasonsCount; $i++) {
            Season::create([
                'series_id' => $id,
                'season_number' => $i,
            ]);
        }

        return redirect()->route('serieinfo', $id)
            ->with('success', 'Temporadas creadas correctamente');
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
    public function destroy($id)
    {
        $temporada = Season::findOrFail($id);

        $serieId = $temporada->series_id;
        $temporada->delete();

        return redirect()->route('serieinfo', ['serieId' => $serieId])->with('success', 'Temporada eliminada correctamente');
    }

    public function temporadainfo($idSerie, $idTemp)
    {
        $serie = Serie::findOrFail($idSerie);

        $temporada = Season::findOrFail($idTemp);
        $temporadaNombre = "Temporada " . $temporada->season_number;
        $serieNombre = $temporada->series->titulo;

        $episodios = Episode::where('serie_id', $idSerie)
            ->where('season_id', $idTemp)
            ->get();

        return view('seasons.info', [
            'serie' => $serie,
            'temporada' => $temporada,
            'episodios' => $episodios,
            'temporadaNombre' => $temporadaNombre,
            'serieNombre' => $serieNombre,
        ]);
    }
}
