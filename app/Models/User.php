<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function pelicula()
    {
        return $this->belongsToMany(Pelicula::class, 'pelicula_user', 'user_id', 'pelicula_id');
    }

    public function series()
    {
        return $this->belongsToMany(Serie::class, 'user_series')->withPivot('status');
    }

    public function episodes()
    {
        return $this->belongsToMany(Episode::class, 'user_epidodes')->withPivot('status');
    }

    public function peliculasVistas()
    {
        return $this->belongsToMany(Pelicula::class, 'pelicula_user')
            ->wherePivot('status_id', '1')
            ->withTimestamps();
    }

    public function peliculasPendientes()
    {
        return $this->belongsToMany(Pelicula::class, 'pelicula_user')
            ->wherePivot('status_id', '2')
            ->withTimestamps();
    }

    public function peliculasSiguiendo()
    {
        return $this->belongsToMany(Pelicula::class, 'pelicula_user')->wherePivot('status_id', '3')->withTimestamps();
    }

    public function peliculasFavoritas()
    {
        return $this->belongsToMany(Pelicula::class, 'pelicula_user')->wherePivot('status_id', '4')->withTimestamps();
    }
}
