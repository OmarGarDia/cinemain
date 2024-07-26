<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateActorRequest extends FormRequest
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
        $id = $this->route('actor');

        return [
            'nombre' => 'required|string|max:255|unique:actors,nombre,' . $id,
            'fecha_nac' => 'required|date',
            'lugar_nac' => 'required|string',
            'bio' => 'nullable|string',
            'imagen_actor' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ];
    }

    public function messages()
    {
        return [
            'nombre.unique' => 'Ya existe ese Actor',
        ];
    }
}
