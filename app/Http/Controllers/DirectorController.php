<?php

namespace App\Http\Controllers;

use App\Models\Director;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Http;
use Exception;

class DirectorController extends Controller
{

    public function index()
    {
        $directores = Director::all();
        return view('directors.directores', compact('directores'));
    }

    public function show(Director $director)
    {
        //$director = Director::findOrFail($id);
        $peliculas = $director->peliculas()->paginate(12);
        $series = $director->series()->paginate(12);
        $numPeliculas = $director->peliculas->count();
        $numSeries = $director->series->count();

        return view('directors.info', compact('director', 'peliculas', 'series', 'numPeliculas', 'numSeries'));
    }

    public function create()
    {
        return view('directors.add');
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'nombre' => 'required|string|max:255|unique:directors,nombre',
                'fecha_nac' => 'required|date',
                'lugar_nac' => 'required|string',
                'imagen_director' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
            ], [
                'nombre.unique' => 'Ya existe ese director',
            ]);

            $director = new Director();
            $director->nombre = $request->nombre;
            $director->fecha_nacimiento = $request->fecha_nac;
            $director->lugar_nacimiento = $request->lugar_nac;

            $file = $request->file('imagen_director');
            if ($file) {
                $file = $request->file('imagen_director');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $filePath = $file->storeAs('directors', $filename, 'public');
                $director->imagen = $filename;
            } else {
                return back()->withErrors(['imagen' => 'El archivo de imagen no se ha cargado correctamente.']);
            }

            $director->save();

            return redirect()->route('directores')->with('success', 'Director almacenado correctamente');
        } catch (ValidationException $e) {
            // Aquí se ejecuta si la validación falla
            $errors = $e->validator->errors()->all();
            return redirect()->back()->withErrors($errors)->withInput();
        }
    }

    public function edit(Director $director)
    {
        //$director = Director::findOrFail($id);
        return view('directors.editar', compact('director'));
    }

    public function update(Request $request, int $id)
    {
        try {
            $request->validate([
                'nombre' => 'required|string|max:255|unique:directors,nombre,' . $id,
                'fecha_nac' => 'required|date',
                'lugar_nac' => 'required|string',
                'imagen_director' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
            ], [
                'nombre.unique' => 'Ya existe ese director',
            ]);

            $director = Director::findOrFail($id);
            $director->nombre = $request->nombre;
            $director->fecha_nacimiento = $request->fecha_nac;
            $director->lugar_nacimiento = $request->lugar_nac;

            if ($request->hasFile('imagen_director')) {
                if ($director->imagen) {
                    Storage::delete('public/directors/' . $director->imagen);
                }

                $imagen = $request->file('imagen_director');
                $nombreImagen = time() . '.' . $imagen->getClientOriginalExtension();
                $imagen->storeAs('public/directors', $nombreImagen);
                $director->imagen = $nombreImagen;
            }

            $director->save();

            return redirect()->route('directores')->with('success', 'Director actualizado correctamente');
        } catch (ValidationException $e) {
            // Aquí se ejecuta si la validación falla
            $errors = $e->validator->errors()->all();
            return redirect()->back()->withErrors($errors)->withInput();
        }
    }

    public function destroy(Director $director)
    {
        try {
            //$director = Director::findOrFail($id);
            $director->delete();
            return redirect()->route('directores')->with('success', 'Director eliminado correctamente.');
        } catch (Exception $e) {
            // Puedes personalizar el mensaje de error según tus necesidades
            return redirect()->route('directores')->with('error', 'Error al eliminar el director. No se puede eliminar un director asociado a una película.');
        }
    }

    public function search(Request $request)
    {
        $query = $request->input('query');

        $response = Http::get('https://api.themoviedb.org/3/search/person', [
            'api_key' => '572048c03066a9b129b919b78cc7e6fc',
            'query' => $query,
        ]);

        if ($response->successful()) {
            return response()->json([
                'results' => $response->json()['results'],
            ]);
        } else {
            return response()->json(['error' => 'Failed to fetch data from API'], $response->status());
        }
    }
}
