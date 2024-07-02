<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function peliculas()
    {
        return $this->belongsToMany(Pelicula::class, 'genre_peliculas');
    }

    public function series()
    {
        return $this->belongsToMany(Serie::class, 'genre_series');
    }
}
