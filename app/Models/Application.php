<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use CyrildeWit\EloquentViewable\InteractsWithViews;
use CyrildeWit\EloquentViewable\Contracts\Viewable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Application extends Model implements Viewable
{
    use HasFactory, InteractsWithViews,  SoftDeletes;


    protected $fillable = [
        'id','name', 'email','country' ,'phone','des_idea' ,'status' ,'role' ,'investment_domain','investment_phase' , 'max_limit'
    ]; 
    

}
