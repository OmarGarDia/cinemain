<?php

namespace App\Services;

use App\Models\Serie;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class SerieService
{
    public function updateSerie(Serie $serie, array $datosActualizados)
    {
        $this->updateAttributes($serie, $datosActualizados);
        $this->handleImageUpload($serie, $datosActualizados);
        $this->syncGenres($serie, $datosActualizados);

        $serie->save();
    }

    public function storeSerie(array $datos)
    {
        $nombreImagen = $this->handleImageUpload($datos['imagen_serie'] ?? null);

        $serie = Serie::create([
            'titulo' => $datos['titulo'],
            'descripcion' => $datos['descripcion'],
            'fecha_estreno' => $datos['fecha_estreno'],
            'director_id' => $datos['director_id'],
            'imagen' => $nombreImagen,
        ]);

        $this->syncGenres($serie, $datos['generos'] ?? []);

        return $serie;
    }

    private function updateAttributes(Serie $serie, array $datosActualizados)
    {
        $serie->fill($datosActualizados);
    }

    private function handleImageUpload(?UploadedFile $imagen): ?string
    {
        if ($imagen) {
            $nombreImagen = time() . '.' . $imagen->getClientOriginalExtension();
            $imagen->storeAs('public/series', $nombreImagen);
            return $nombreImagen;
        }
        return null;
    }

    private function syncGenres(Serie $serie, array $generos)
    {
        $serie->genres()->sync($generos);
    }
}
