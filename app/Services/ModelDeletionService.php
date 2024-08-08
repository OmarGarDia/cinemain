<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ModelDeletionService
{
    protected $pathResolver;

    public function __construct($pathresolver = null)
    {
        $this->pathResolver = $pathresolver;
    }

    public function delete(Model $model)
    {
        if ($this->pathResolver && $model->imagen) {
            $imagePath = $this->pathResolver->resolve($model->imagen);
            if (Storage::exists($imagePath)) {
                Storage::delete($imagePath);
            }
        }

        $model->delete();
    }
}
