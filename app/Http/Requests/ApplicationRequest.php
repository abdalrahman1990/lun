<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ApplicationRequest extends FormRequest
{
   
    public function rules()
    {
        return [
            
            'name'     =>  'required|min:5',
            'email'    =>  'required|email',
            'country'  =>  'required|string',
            'phone'    =>  'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10|max:14',
            'des_idea' =>  'required|string',
            'status'   =>  'required|string',
            'role'     =>  'required|string',

        ];
    }

    public function messages()
    {
        return [

            'name.reuired'      => 'A nice name is required for the application.',
            'email.required'    => 'Please add email for the application.',
            'country.required'  => 'Please add country for the application.',
            'phone.required'    => 'Please add phone for the application.',
            'des_idea.required' => 'Please add des_idea for the application.',
            'status.required'   => 'Please add status for the application.',
            'role.required'     => 'Please add role for the application.',
            
        ];
    }
}
