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

        return view('episodes.add', [
            'serie' => $serie,
            'temporada' => $temporada,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($idSerie, $idTemp)
    {
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $idSerie, $idTemp)
    {
        // Valida los datos del formulario
        $validatedData = $request->validate([
            'episode_number' => 'required|numeric',
            'title' => 'required|string',
            'sinopsis' => 'required|string',
            'fecha_estreno' => 'required|date',
        ]);

        // Crea una instancia del modelo Episode con los datos validados
        $episode = new Episode();
        $episode->serie_id = $idSerie; // Asigna el ID de la serie
        $episode->season_id = $idTemp; // Asigna el ID de la temporada
        $episode->episode_number = $validatedData['episode_number'];
        $episode->title = $validatedData['title'];
        $episode->sinopsis = $validatedData['sinopsis'];
        $episode->fecha_estreno = $validatedData['fecha_estreno'];

        // Guarda el episodio en la base de datos
        $episode->save();

        // Redirige a alguna ruta adecuada después de guardar el episodio
        return redirect()->route('addepisode');
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
