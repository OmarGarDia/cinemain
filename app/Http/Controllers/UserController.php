<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('users.user', compact('users'));
    }

    public function countUsers()
    {
        $users = User::all()->count();

        return view('dashboard', compact('users'));
    }

    public function edit(int $id)
    {
        $users = User::findOrFail($id);
        return view('users.edit', compact('users'));
    }

    public function update(Request $request, int $id)
    {
        try {
            $request->validate([
                'name_edit' => 'required|string',
                'email_edit' => [
                    'required',
                    'email',
                    Rule::unique('users', 'email')->ignore($id),
                ],
                'password_edit' => 'nullable|string|min:8|confirmed', // Añade confirmed para verificar el campo confirmación
            ], [
                'password_edit.confirmed' => 'Las contraseñas no coinciden.',
            ]);

            $user = User::findOrFail($id);
            $user->name = $request->name_edit;
            $user->email = $request->email_edit;

            // Si se proporciona una nueva contraseña, actualizarla
            if ($request->filled('password_edit')) {
                $user->password = Hash::make($request->password_edit);
            }

            $user->save();

            Session::flash('success', 'Usuario actualizado correctamente.');
            return redirect()->route('usuarios');
        } catch (ValidationException $e) {
            Session::flash('error', $e->validator->errors()->first());
            return redirect()->back()->withErrors($e->validator)->withInput();
        }
    }
}
