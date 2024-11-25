<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValidarRegistro extends FormRequest
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
    public function rules()
    {
        return [
            'nombre' => 'required|string|min:3|max:255',
            'ap_reg' => 'required|string|min:3|max:255',
            'am_reg' => 'required|string|min:3|max:255',
            'radio_gen' =>'required',
            'telefono' => 'required|numeric|digits:10',
            'correo' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
        ];
    }
}
