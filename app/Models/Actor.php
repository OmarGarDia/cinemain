<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Actor extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre', 'bio', 'fecha_nacimiento', 'nacionalidad', 'imagen'
    ];

    public function peliculas()
    {
        return $this->belongsToMany(Pelicula::class, 'actor_pelicula');
    }

    public function series()
    {
        return $this->belongsToMany(Serie::class, 'actor_series', 'series_id', 'actor_id');
    }
}
