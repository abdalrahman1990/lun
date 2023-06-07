<?php

namespace App\Http\Controllers;


use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest ;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Requests\JobRequest ;


class UserController extends ApiController
{
    //-- function make user update his information--//

    public function editProfile(UserRequest $request)
    {

        $user = auth()->user();
        $data = $request->all();
      // dd($user);
        if(!$user){
            return $this->error(['error' => 'User_update'], 'Invalid request');
        }

        if ($request->hasFile('pic')) {

            $image 		     = $request->file('pic');
            $filename 	   = Str::uuid().'.'.time().'.'.$request->pic->getClientOriginalExtension();
            $image         ->storeAs('/users', $filename);
            $data['pic']   = $filename;
        }
         
          $user->update($data);

        return $this->success();
    }


    //-- get user information from his auth --//

    public function userInfo()
    {
        $user = Auth()->User();

        return $this->success($user);
    }

  }
