<?php

namespace App\Http\Services;

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

    private function updateAttributes(Serie $serie, array $datosActualizados)
    {
        $serie->fill($datosActualizados);
    }

    private function handleImageUpload(Serie $serie, array $datosActualizados)
    {
        if (isset($datosActualizados['imagen_serie']) && $datosActualizados['imagen_serie'] instanceof UploadedFile) {
            $imagen = $datosActualizados['imagen_serie'];
            $nombreImagen = time() . '.' . $imagen->getClientOriginalExtension();
            $imagen->storeAs('public/series', $nombreImagen);

            // Eliminar imagen anterior si existe
            if ($serie->imagen) {
                Storage::delete('public/series/' . $serie->imagen);
            }

            $serie->imagen = $nombreImagen;
        }
    }

    private function syncGenres(Serie $serie, array $datosActualizados)
    {
        if (isset($datosActualizados['generos'])) {
            $serie->genres()->sync($datosActualizados['generos']);
        }
    }
}
