<?php

namespace App\Http\Controllers;

use App\Models\Actor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Exception;


class ActoresController extends Controller
{

    public function index()
    {
        $actores = Actor::get();
        return view('actors.actores', compact('actores'));
    }

    public function show(Actor $actor)
    {
        //$actor = Actor::findOrFail($id);
        $peliculas = $actor->peliculas()->paginate(12);
        $series = $actor->series()->paginate(12);
        $numPeliculas = $actor->peliculas->count();
        $numSeries = $actor->series->count();
        return view('actors.info', compact('actor', 'peliculas', 'series', 'numSeries', 'numPeliculas'));
    }

    public function create()
    {
        return view('actors.add');
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'nombre' => 'required|string|max:255|unique:actors,nombre',
                'fecha_nac' => 'required|date',
                'lugar_nac' => 'required|string',
                'bio' => 'nullable|string',
                'imagen_actor' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
            ], [
                'nombre.unique' => 'Ya existe ese actor',
            ]);

            $actor = new Actor();
            $actor->nombre = $request->nombre;
            $actor->fecha_nacimiento = $request->fecha_nac;
            $actor->nacionalidad = $request->lugar_nac;
            $actor->bio = $request->bio;

            $file = $request->file('imagen_actor');
            if ($file) {
                $file = $request->file('imagen_actor');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $filePath = $file->storeAs('actors', $filename, 'public');
                $actor->imagen = $filename;
            } else {
                return back()->withErrors(['imagen' => 'El archivo de imagen no se ha cargado correctamente.']);
            }

            $actor->save();

            return redirect()->route('actores')->with('success', 'Actor/Actriz almacenado correctamente');
        } catch (ValidationException $e) {
            // Aquí se ejecuta si la validación falla
            $errors = $e->validator->errors()->all();
            return redirect()->back()->withErrors($errors)->withInput();
        }
    }

    public function edit(Actor $actor)
    {
        //$actor = Actor::findOrFail($id);
        return view('actors.editar', compact('actor'));
    }

    public function update(Request $request, Actor $actor)
    {
        try {

            //$actor = Actor::findOrFail($id);
            $actor->nombre = $request->nombre;
            $actor->fecha_nacimiento = $request->fecha_nac;
            $actor->nacionalidad = $request->lugar_nac;
            $actor->bio = $request->bio;

            if ($request->hasFile('imagen_director')) {
                if ($actor->imagen) {
                    Storage::delete('public/actors/' . $actor->imagen);
                }

                $imagen = $request->file('imagen_actor');
                $nombreImagen = time() . '.' . $imagen->getClientOriginalExtension();
                $imagen->storeAs('public/actors', $nombreImagen);
                $actor->imagen = $nombreImagen;
            }

            $actor->save();

            return redirect()->route('actores')->with('success', 'Actor actualizado correctamente');
        } catch (ValidationException $e) {
            // Aquí se ejecuta si la validación falla
            $errors = $e->validator->errors()->all();
            return redirect()->back()->withErrors($errors)->withInput();
        }
    }

    public function destroy(Actor $actor)
    {
        try {
            //$actor = Actor::findOrFail($id);
            $actor->delete();
            return redirect()->route('actores')->with('success', 'Actor/actriz eliminado correctamente.');
        } catch (Exception $e) {
            return redirect()->route('actores')->with('error', 'Error al eliminar el actor/actriz. No se puede eliminar un actor asociado a una película.');
        }
    }
}
