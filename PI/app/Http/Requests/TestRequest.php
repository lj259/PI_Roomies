<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TestRequest extends FormRequest
{
    
    public function authorize()
    {
        return true;
    }
    
    public function rules()
    {
        return [
            'q1' => 'required|in:si,no',
            'q2' => 'required|in:si,no',
            'q3' => 'required|in:si,no',
            'q4' => 'required|in:si,no',
            'q5' => 'required|in:si,no',
        ];
    }

}
