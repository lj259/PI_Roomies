<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValidarEditDepa extends FormRequest
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
            'foto'=>' image|mimes:jpeg,png,jpg,gif|max:2048',
            'precio'=>'required | numeric',
            'titulo'=>'required',
            'direccion'=>'required',
            'descripcion'=>'required',
            'latitud'=>'required | numeric',
            'longitud'=>'required | numeric',
            'habitaciones_disponibles'=>'required | numeric | digits_between:1,2 | max:20',
            'disponible_para'=>'required',
            'servicios' => 'nullable|array',
            'servicios.*' => 'string|in:Wi-Fi,Aire acondicionado,Estacionamiento,Piscina,Amueblado'
        ];
    }
}
