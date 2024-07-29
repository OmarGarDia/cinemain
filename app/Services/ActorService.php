<?php

namespace App\Services;

use App\Models\Actor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ActorService
{

    public function handleImagen(Request $request, Actor $actor)
    {
        if ($actor->imagen) {
            Storage::delete('public/actors/' . $actor->imagen);
        }

        $imagen = $request->file('imagen_actor');
        $nombreImagen = time() . '.' . $imagen->getClientOriginalExtension();
        $imagen->storeAs('public/actors', $nombreImagen);
        $actor->imagen = $nombreImagen;

        $actor->save();
    }
}
