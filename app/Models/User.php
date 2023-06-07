<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use CyrildeWit\EloquentViewable\InteractsWithViews;
use CyrildeWit\EloquentViewable\Contracts\Viewable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

use App\Models\Role;

class User extends Authenticatable implements JWTSubject , Viewable
{
    use HasApiTokens, HasFactory, Notifiable , InteractsWithViews;

   
    protected $fillable = [
        'name', 'email','phone' ,'password', 'pic', 'fcm_token', 
    ];
    
    protected $hidden = [
        'password',
        'remember_token',
    ];


    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }


    public function authorizeRoles($roles)
    {
        if (is_array($roles)) {
            return $this->hasAnyRole($roles) ||
            abort(401, 'This action is unauthorized.');
        }
        return $this->hasRole($roles) ||
        abort(401, 'This action is unauthorized.');
    }


    
    public function hasRole($role)
    {
        return null !== $this->roles()->where('name', $role)->first();
    }


    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    
    public function getJWTCustomClaims()
    {
        return [];
    }

   

    
}
