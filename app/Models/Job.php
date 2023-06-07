<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\C_v;
class Job extends Model
{
    use HasFactory , SoftDeletes;
    

    protected $fillable = [
        'id','title', 'type','hierarchical' ,'salary', 'address','experience' ,'description','requirement','status','start_time','end_time','image'
    ]; 
    
    public function c_vs()
    {
        return $this->hasMany(C_v::class);
    }

    
}
