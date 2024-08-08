<?php

namespace App\Services\PathResolver;

class PeliculasPathResolver
{
    public function resolve($imageName)
    {
        return 'public/movies/' . $imageName;
    }
}
