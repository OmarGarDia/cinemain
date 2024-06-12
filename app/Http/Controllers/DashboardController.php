<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Pelicula;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $users = User::count();
        $peliculas = Pelicula::count();

        return view('/dashboard', compact('users', 'peliculas'));
    }
}
