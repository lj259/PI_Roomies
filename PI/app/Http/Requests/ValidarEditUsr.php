<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValidarEditUsr extends FormRequest
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
            'nombre'=>'required | regex:/^[\pL\s]+$/u | min:2 | max:180',
            'apellido_p'=>'required | regex:/^[\pL\s]+$/u | min:2 | max:180',
            'apellido_m'=>'required | regex:/^[\pL\s]+$/u | min:2 | max:180',
            'telefono'=>'required | numeric | digits:10',
            'correo'=>'required | email | string',
            'genero'=> 'required | string | regex:/^[\pL\s]+$/u',
            'status'=> 'required | integer',

        ];
    }
}
