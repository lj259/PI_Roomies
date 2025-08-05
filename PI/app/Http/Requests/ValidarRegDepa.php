<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValidarRegDepa extends FormRequest
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
            'titulo' => 'required|string|max:255|regex:/^[\pL0-9\s]+$/u',
            'propietario_id' => 'required|integer',
            'descripcion' => 'required|string|regex:/^[\pL0-9\s]+$/u',
            'direccion' => 'required|string|regex:/^[\pL0-9\s]+$/u',
            'latitud' => 'required|numeric',
            'longitud' => 'required|numeric',
            'precio' => 'required|numeric|min:0',
            'habitaciones_disponibles' => 'required|integer|min:1',
            'disponible_para'=> 'required| string|regex:/^[\pL0-9\s]+$/u',
            'servicios' => 'nullable|array',
            'imagenes' => 'nullable|array',
            'imagenes.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }
}
