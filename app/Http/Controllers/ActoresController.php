<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreActorRequest;
use App\Services\ActorService;
use App\Http\Requests\UpdateActorRequest;
use App\Models\Actor;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Exception;


class ActoresController extends Controller
{

    protected $actorService;

    public function __construct(ActorService $actorService)
    {
        $this->actorService = $actorService;
    }

    public function index()
    {
        $actores = Actor::get();
        return view('actors.actores', compact('actores'));
    }

    public function show(Actor $actor)
    {
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

    public function store(StoreActorRequest $request)
    {
        try {
            $actor = new Actor();
            $actor->nombre = $request->nombre;
            $actor->fecha_nacimiento = $request->fecha_nac;
            $actor->nacionalidad = $request->lugar_nac;
            $actor->bio = $request->bio;

            if ($request->hasFile('imagen_actor')) {
                $this->actorService->handleImagen($request, $actor);
            } else {
                return back()->withErrors(['imagen' => 'El archivo de imagen no se ha cargado correctamente']);
            }

            $actor->save();

            return redirect()->route('actores')->with('success', 'Actor/Actriz almacenado correctamente');
        } catch (ValidationException $e) {
            $errors = $e->validator->errors()->all();
            return redirect()->back()->withErrors($errors)->withInput();
        }
    }

    public function edit(Actor $actor)
    {
        return view('actors.editar', compact('actor'));
    }

    public function update(UpdateActorRequest $request, Actor $actor)
    {

        $actor->nombre = $request->nombre;
        $actor->fecha_nacimiento = $request->fecha_nac;
        $actor->nacionalidad = $request->lugar_nac;
        $actor->bio = $request->bio;

        if ($request->hasFile('imagen_actor')) {
            $this->actorService->handleImagen($request, $actor);
        }

        $actor->save();

        return redirect()->route('actores')->with('success', 'Actor actualizado correctamente');
    }

    public function destroy(Actor $actor)
    {
        try {
            $actor->delete();
            return redirect()->route('actores')->with('success', 'Actor/actriz eliminado correctamente.');
        } catch (Exception $e) {
            return redirect()->route('actores')->with('error', 'Error al eliminar el actor/actriz. No se puede eliminar un actor asociado a una película.');
        }
    }
}
