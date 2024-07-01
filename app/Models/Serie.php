<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Serie extends Model
{
    use HasFactory;

    protected $fillable = ['titulo', 'descripcion', 'fecha_estreno', 'director_id'];

    public function actors()
    {
        return $this->belongsToMany(Actor::class);
    }

    public function seasons()
    {
        return $this->hasMany(Season::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_series')->withPivot('status');
    }
}
