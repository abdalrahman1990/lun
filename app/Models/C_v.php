<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use App\Models\Job;
use Illuminate\Database\Eloquent\SoftDeletes;


class C_v extends Model
{
    use HasFactory,  Notifiable , SoftDeletes;

   protected  $guarded = [] ;

    public function job()
    {
        return $this->belongsTo(Job::class, 'job_id');
    }
}
