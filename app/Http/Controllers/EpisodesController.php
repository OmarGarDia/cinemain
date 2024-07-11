<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Season;
use App\Models\Serie;
use App\Models\Episode;

class EpisodesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($idSerie, $idTemp)
    {
        $serie = Serie::findOrFail($idSerie);
        $temporada = Season::findOrFail($idTemp);

        $episodios = Episode::where('serie_id', $idSerie)
            ->where('season_id', $idTemp)
            ->get();

        // Pasar los datos a la vista
        return view('seasons.info', [
            'serie' => $serie,
            'temporada' => $temporada,
            'episodios' => $episodios,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($idSerie, $idTemp)
    {

        $serie = Serie::findOrFail($idSerie);

        $temporada = Season::findOrFail($idTemp);

        return view('episodes.add', [
            'serie' => $serie,
            'temporada' => $temporada,
        ]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'season_id' => 'required|exists:seasons,id',
            'serie_id' => 'required|exists:series,id',
            'episode' => 'required|numeric',
            'title' => 'required|string',
            'sinopsis' => 'required|string',
            'fecha_estreno' => 'required|date',
        ]);

        $episode = new Episode();
        $episode->season_id = $request->season_id;
        $episode->serie_id = $request->serie_id;
        $episode->episode_number = $request->episode;
        $episode->title = $request->title;
        $episode->sinopsis = $request->sinopsis;
        $episode->fecha_estreno = $request->fecha_estreno;

        $episode->save();

        return redirect()->route('temporadainfo', ['idSerie' => $request->serie_id, 'idTemp' => $request->season_id])->with('success', 'Episodio añadido correctamente');
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
}
