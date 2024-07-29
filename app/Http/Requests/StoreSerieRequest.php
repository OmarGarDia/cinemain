<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSerieRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'titulo' => 'required',
            'descripcion' => 'nullable',
            'fecha_estreno' => 'nullable|integer',
            'director_id' => 'nullable|exists:directors,id',
            'imagen_serie' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'generos' => 'required|array',
            'generos.*' => 'exists:genres,id',
        ];
    }
}
