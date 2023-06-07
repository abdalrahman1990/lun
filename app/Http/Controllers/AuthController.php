<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Str;


class AuthController extends Controller
{


    public function register(Request $request)
    {
    	//Validate data
        $data = $request->only('name', 'email','phone', 'password','remember_token');
        $validator = Validator::make($data, [
            'name'  => 'required|string',
            'email'  => 'required|email|unique:users',
            'phone'   => 'required|integer|min:10',
            'password' => 'required|string|min:6|max:10'
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }

        //Request is valid, create new user
        $user = User::create([

        	'name'  => $request->name,
        	'email' => $request->email,
            'phone' => $request->phone,
        	'password' => bcrypt($request->password),
           // 'remember_token' =>Str::random(200)

        ]);

        //User created, return success response
        return response()->json([
            'success' => true,
            'message' => 'User created successfully',
            'data' => $user
        ], Response::HTTP_OK);
    }

    
    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');

        //valid credential
        $validator = Validator::make($credentials, [
            'email' => 'required|email',
            'password' => 'required|string|min:6|max:50',
            //'fcm_token'  => 'nullable'
        ]);
       

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }

        //Request is validated
        //Crean token
        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json([
                	'success' => false,
                	'message' => 'Login credentials are invalid.',
                ], 400);
            }
        } catch (JWTException $e) {
    	return $credentials;
            return response()->json([
                	'success' => false,
                	'message' => 'Could not create token.',
                ], 500);
        
        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return $next($request);
        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Token Invalid',
            ], 500);
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json([
                'status' => 500,
                'message' => $e->getMessage(),
            ], 500);
        }
        
        $user = User::find(3)->update(['fcm_token' => $request->fcm_token]);

 		//Token created, return with success response and jwt token
        return response()->json([
            'success' => true,
            'token'   => $token,
        ]);
    }


    
    public function logout(Request $request)
    {
        $this->validate($request, [
            'token' => 'required'
        ]);
  
        try {
            JWTAuth::invalidate($request->token);
  
            return response()->json([
                'success' => true,
                'message' => 'User logged out successfully'
            ]);
        } catch (JWTException $exception) {

           // $user = User::find(7)->delete(['fcm_token' => $request->fcm_token]);

            return response()->json([
                'success' => true,
                'message' => 'User logged out successfully *'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    
    public function getUser(Request $request)
    {
        $this->validate($request, [
            'token' => 'required'
        ]);
  
        $user = JWTAuth::authenticate($request->token);
  
        return response()->json(['user' => $user]);
    }



    public function refresh() {
        return $this->createNewToken(auth()->refresh());
    }


}
