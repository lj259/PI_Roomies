<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValidarReportarUsr extends FormRequest
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
            'chbox1' => 'nullable',
            'chbox2' => 'nullable',
            'chbox3' => 'nullable',
            'chbox4' => 'nullable',
            'chbox5' => 'nullable',
            'other' => 'nullable',
        ];
    }

    
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if (!$this->filledAnyCheckboxOrText()) {
                $validator->errors()->add('general', 'Debes seleccionar al menos una opción o rellenar el campo de texto.');
            }
        });
    }

    private function filledAnyCheckboxOrText()
    {
        return $this->filled('other') ||
            $this->boolean('chbox1') ||
            $this->boolean('chbox2') ||
            $this->boolean('chbox3') ||
            $this->boolean('chbox4') ||
            $this->boolean('chbox5');
    }
}
