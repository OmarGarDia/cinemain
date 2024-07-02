<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Genre;

class GenreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $genres = [
            'Acción', 'Aventuras', 'Animación', 'Comedia', 'Crimen', 'Documental', 'Drama',
            'Familiar', 'Fantasía', 'Historia', 'Horror', 'Musical', 'Misterio', 'Romance',
            'Ciencia-Ficción', 'Suspense', 'Bélica', 'Western'
        ];

        foreach ($genres as $genre) {
            Genre::create(['name' => $genre]);
        }
    }
}
