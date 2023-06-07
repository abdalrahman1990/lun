<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JobRequest extends FormRequest
{
   
   
    public function rules()
    {
        return [
            
           // 'title'       => 'required|string|unique:jobs',
            'title'       => 'required|string',
            'address'     => 'required|string',
            'salary'      => 'required|string',
            'description' => 'required|string',
            'type'        => 'required|string',
            'hierarchical'=> 'required|string',
            'experience'  => 'required|string',
            'requirement' => 'required|string',
            'status'      => 'required|string',
            'image'       => 'nullable|image|max:1024',
        
        ];
     
    }


    public function messages()
    {
        return [
            'title.reuired'        => 'A nice title is required for the job.',
            'address.required'     => 'Please add address for the job.',
            'salary.required'      => 'Please add salary for the job.',
            'description.required' => 'Please add description for the job.',
            'type.required'        => 'Please add type for the job.',
            'experience.required'  => 'Please add experience for the job.',
            'requirement.required' => 'Please add requirement for the job.',
            'status.required'      => 'Please add status for the job.',
            'hierarchical.required'=> 'Please add hierarchical for the job.',
        ];
    }


}
