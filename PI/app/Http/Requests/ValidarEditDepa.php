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
            'foto'=>'required',
            'precio'=>'required | numeric',
            'ubicacion'=>'required',
            'habitaciones'=>'required | numeric | digits_between:1,2 | max:20',
            'banos'=>'required | numeric | digits_between:1,2 | max:15',
            'servicios'=>'required',
            'restricciones'=>'required',
            'cercanias'=>'required',
        ];
    }
}
