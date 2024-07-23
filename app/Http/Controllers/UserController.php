<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest;
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

    public function userinfo($userId)
    {
        $user = User::with(['peliculasVistas', 'peliculasPendientes', 'peliculasSiguiendo', 'peliculasFavoritas'])->findOrFail($userId);

        return view('users.info', [
            'user' => $user,
            'peliculasVistas' => $user->peliculasVistas,
            'peliculasPendientes' => $user->peliculasPendientes,
            'peliculasSiguiendo' => $user->peliculasSiguiendo,
            'peliculasFavoritas' => $user->peliculasFavoritas,
        ]);
    }

    public function edit(User $user)
    {
        //$users = User::findOrFail($id);
        return view('users.edit', compact('users'));
    }

    public function update(UpdateUserRequest $request, int $id)
    {
        try {
            $user = User::findOrFail($id);
            $user->update($request->only('name_edit', 'email_edit'));
            if ($request->filled('password_edit')) {
                $user->update(['password' => Hash::make($request->password_edit)]);
            }
            Session::flash('success', 'Usuario actualizado correctamente.');
            return redirect()->route('usuarios');
        } catch (ValidationException $e) {
            Session::flash('error', $e->validator->errors()->first());
            return redirect()->back()->withErrors($e->validator)->withInput();
        }
    }

    public function destroy(User $user)
    {
        //$user = User::findOrFail($id);
        $user->delete();
        Session::flash('success', 'Usuario eliminado correctamente.');
        return redirect()->route('usuarios');
    }
}
