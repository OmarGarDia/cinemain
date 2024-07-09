<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Serie extends Model
{
    use HasFactory;

    protected $fillable = ['titulo', 'descripcion', 'fecha_estreno', 'director_id', 'imagen'];

    public function actores()
    {
        return $this->belongsToMany(Actor::class, 'actor_series', 'series_id', 'actor_id');
    }

    public function seasons()
    {
        return $this->hasMany(Season::class, 'series_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_series')->withPivot('status');
    }

    public function director()
    {
        return $this->belongsTo(Director::class, 'director_id');
    }

    public function genres()
    {
        return $this->belongsToMany(Genre::class, 'genre_series', 'series_id', 'genre_id');
    }
}
