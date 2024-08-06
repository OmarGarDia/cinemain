<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Episode extends Model
{
    use HasFactory;

    protected $table = 'episode';

    protected $fillable = ['serie_id', 'season_id', 'episode', 'title', 'sinopsis', 'fecha_estreno'];
    protected $dates = ['fecha_estreno'];

    public function season()
    {
        return $this->belongsTo(Season::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_episodes')->withPivot('status');
    }
}
