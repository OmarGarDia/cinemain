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
        $users = User::where('role_id', '!=', 1)->get();

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
        return view('users.edit', compact('user'));
    }

    public function update(UpdateUserRequest $request, int $id)
    {
        try {
            $user = User::findOrFail($id);
            $updateData = $request->only('name_edit', 'email_edit');

            $user->name = $updateData['name_edit'] ?? $user->name;
            $user->email = $updateData['email_edit'] ?? $user->email;
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

    public function destroy(User $user)
    {
        //$user = User::findOrFail($id);
        $user->delete();
        Session::flash('success', 'Usuario eliminado correctamente.');
        return redirect()->route('usuarios');
    }
}
