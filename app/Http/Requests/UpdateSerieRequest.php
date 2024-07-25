<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSerieRequest extends FormRequest
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
        $id = $this->route('id');

        return [
            'titulo' => 'required|string|max:255|unique:series,titulo,' . $id,
            'fecha_estreno' => 'required|integer',
            'director_id' => 'nullable|exists:directors,id',
            'descripcion' => 'required|string',
            'imagen_serie' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ];
    }

    public function messages()
    {
        return [
            'titulo.unique' => 'Ya existe una serie con ese titulo',
        ];
    }
}
