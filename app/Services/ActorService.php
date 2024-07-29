<?php

namespace App\Services;

use App\Http\Requests\UpdateActorRequest;
use App\Models\Actor;
use Illuminate\Support\Facades\Storage;

class ActorService
{

    public function handleImagen(UpdateActorRequest $request, Actor $actor)
    {
        if ($actor->imagen) {
            Storage::delete('public/actors/' . $actor->imagen);
        }

        $imagen = $request->file('imagen_actor');
        $nombreImagen = time() . '.' . $imagen->getClientOriginalExtension();
        $imagen->storeAs('public/actors', $nombreImagen);
        $actor->imagen = $nombreImagen;
    }
}
