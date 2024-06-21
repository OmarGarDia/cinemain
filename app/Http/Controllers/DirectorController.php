<?php

namespace App\Http\Controllers;

use App\Models\Director;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;


class DirectorController extends Controller
{

    public function index()
    {
        $directores = Director::all();
        return view('directors.directores', compact('directores'));
    }

    public function show($id)
    {
        $director = Director::findOrFail($id);
        $peliculas = $director->peliculas()->paginate(12);
        $numPeliculas = $director->peliculas->count();

        return view('directors.info', compact('director', 'peliculas', 'numPeliculas'));
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
}
