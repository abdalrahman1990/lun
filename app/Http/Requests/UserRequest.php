<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
   
    public function rules()
    {
        return [

            'name'     => 'string',
            'email'    => 'email',
            'pic'      => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'password' => 'string|min:6|max:50',
            'phone'    => 'integer|min:10',
        ];
    }

    public function messages()
    {
        return [

            'name'         => 'A nice name is required',
            'email'        => 'Please add email ',
            'pic'          => 'Please add photo ',
            'password'     => 'Please add password ',
            'phone'        => 'Please add  phone number ',
            
            
        ];
    }
}
