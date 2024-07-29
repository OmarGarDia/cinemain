<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDirectorRequest extends FormRequest
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
        $director = $this->route('director');

        return [
            'nombre' => 'required|string|max:255|unique:directors,nombre,' . $director->id,
            'fecha_nac' => 'required|date',
            'lugar_nac' => 'required|string',
            'imagen_director' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ];
    }

    public function messages()
    {
        return [
            'nombre.unique' => 'Ya existe ese director',
        ];
    }
}
