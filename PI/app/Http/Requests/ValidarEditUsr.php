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
            'telefono'=>'nullable | numeric | digits:10',
            'correo'=>'required | email | string',
            'genero'=> 'required | in:masculino,femenino,otro',
            'rol'=> 'required | in:usuario,admin',
            'foto_perfil' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre es obligatorio.',
            'nombre.regex' => 'El nombre solo puede contener letras y espacios.',
            'apellido_p.required' => 'El apellido paterno es obligatorio.',
            'apellido_p.regex' => 'El apellido paterno solo puede contener letras y espacios.',
            'apellido_m.required' => 'El apellido materno es obligatorio.',
            'apellido_m.regex' => 'El apellido materno solo puede contener letras y espacios.',
            'telefono.numeric' => 'El teléfono debe ser numérico.',
            'telefono.digits' => 'El teléfono debe tener exactamente 10 dígitos.',
            'correo.required' => 'El correo electrónico es obligatorio.',
            'correo.email' => 'El correo electrónico debe tener un formato válido.',
            'genero.required' => 'Debe seleccionar un género.',
            'genero.in' => 'El género seleccionado no es válido.',
            'rol.required' => 'Debe seleccionar un rol.',
            'rol.in' => 'El rol seleccionado no es válido.',
            'foto_perfil.image' => 'El archivo debe ser una imagen.',
            'foto_perfil.mimes' => 'La imagen debe ser de tipo: jpeg, png, jpg, gif.',
            'foto_perfil.max' => 'La imagen no debe superar los 2MB.',
        ];
    }
}
