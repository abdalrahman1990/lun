<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class C_vRequest extends FormRequest
{
   
   
    public function rules()
    {
        return [

            
            'file' => 'required|mimes:pdf',

        ];
    }

    public function messages()
    {
        return [

            'file.reuired'        => 'PDF File Is Required.',
            
        ];
    }
}
