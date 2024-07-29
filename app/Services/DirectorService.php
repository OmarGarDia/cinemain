<?php

namespace App\Services;

use App\Models\Director;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DirectorService
{
    public function handleImagen(Request $request, Director $director)
    {
        if ($director->imagen) {
            Storage::delete('public/directors/' . $director->imagen);
        }

        $imagen = $request->file('imagen_director');
        $nombreImagen = time() . '.' . $imagen->getClientOriginalExtension();
        $imagen->storeAs('public/directors/' . $nombreImagen);
        $director->imagen = $nombreImagen;
    }
}
