<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Entrepreneur extends Model
{
    use HasFactory , SoftDeletes;

    protected $fillable = [
        'step1', 'step2' ,'step3' ,'step4' ,'step5' ,'step6' ,'step7' ,'step8' ,'step9' ,'logo'
    ]; 

    protected $casts = [

        'step1' => 'array',
        'step2' => 'array',
        'step3' => 'array',
        'step4' => 'array',
        'step5' => 'array',
        'step6' => 'array',
        'step7' => 'array',
        'step8' => 'array',
        'step9' => 'array'
        
    ];

    

}
