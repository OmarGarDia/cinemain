<?php

namespace App\Services\PathResolver;

class seriesPathResolver
{
    public function resolve($imageName)
    {
        return 'public/series/' . $imageName;
    }
}
