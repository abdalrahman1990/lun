<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VisitorRequest extends FormRequest
{
   
    public function rules()
    {
        return [
            
            'start'   => 'date',
            'end'     => 'date|after:start',
           
        ];
     
    }


    public function messages()
    {
        return [
            'start'   => 'A nice title is required for the job.',
            'end'     => 'Please add address for the job.',
            
        ];
    }


}
