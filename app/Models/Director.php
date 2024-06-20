<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Director extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre', 'fecha_nacimiento', 'lugar_nacimiento', 'imagen',
    ];

    public function peliculas()
    {
        return $this->hasMany(Pelicula::class);
    }
}
