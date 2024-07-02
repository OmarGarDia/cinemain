<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelicula extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo',
        'año',
        'sinopsis',
        'duracion',
        'idioma',
        'pais',
        'calificacion',
        'imagen',
        'fecha_estreno',
        'director_id'
    ];

    protected $dates = ['created_at', 'updated_at'];

    public function users()
    {
        return $this->belongsToMany(User::class, 'pelicula_user', 'movie_id', 'user_id');
    }

    public function director()
    {
        return $this->belongsTo(Director::class);
    }

    public function actores()
    {
        return $this->belongsToMany(Actor::class, 'actor_pelicula');
    }

    public function genres()
    {
        return $this->belongsToMany(Genre::class, 'genre_peliculas', 'pelicula_id', 'genre_id');
    }
}
