<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Notifications\SendNotification;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Services\FCMService;
use Kutia\Larafirebase\Facades\Larafirebase;
use App\Notifications\SendPushNotification;
use Illuminate\Support\Facades\Notification;



class NotificationController extends ApiController
{


    public function sendNotification() {

        $userSchema = auth()->user();

        $sentData = [
            'name' => 'BOGO',
            'body' => 'You received an new thing.',
            'thanks' => 'Thank you',
            'offerText' => 'Check out there is new thing.',
            'offerUrl' => url('/'),
            'id' => 003
        ];

        $userSchema ->notify(new SendNotification($sentData,$title ='hi sir',$message='new cv added',$fcmTokens));

        return $this->success();

    }


    public function index()
    {
        return view('welcome');
    }


    public function updateToken(Request $request){

        try{

            $user = auth()->user();
            $user->update(['fcm_token'=>$request->token]);

            return response()->json([
                'success'=> true
            ]);

            }catch(\Exception $e){

                report($e);

                return response()->json([
                    'success'=>false
                ],500);
            }
    }


    public function storeToken(Request $request){

        $fcm_token =$request->token;

        $user = auth()->user();

        $user->update(['fcm_token'=>$fcm_token]);

        return response()->json( "true");

    }


    public function sendWebNotification(Request $request)
    {
        $url = 'https://fcm.googleapis.com/fcm/send';

        $FcmToken  = User::whereNotNull('fcm_token')->pluck('fcm_token')->all();

        $serverKey = 'AAAA68CvZRs:APA91bE2sRKIlBfBbhqhb5B99UUvtLLmkOcxJQ5tI63Rhot-LEzTsO7PVbB7IdOqWzBJxW7--JyidnP0S_O5h-f5YZUAVwgO6Ep6-slaLOyaaLjyq5bKsxl1pO6H7qhq1OnhWY_h3RyL';

        $data = [

                "registration_ids" => $FcmToken,
                "notification" => [
                "title" => $request->title,
                "body" => $request->body,
            ]
        ];

        $encodedData = json_encode($data);

        $headers = [
            'Authorization:key=' . $serverKey,
            'Content-Type: application/json',
        ];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        // Disabling SSL Certificate support temporarly
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $encodedData);
        // Execute post
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }
        // Close connection
        curl_close($ch);
        // FCM response
        dd($result);
    }


    public function notification(Request $request){

        $request->validate([
            'title'=>'required',
            'message'=>'required'
        ]);

        try{

            $fcmTokens = User::whereNotNull('fcm_token')->pluck('fcm_token')->toArray();

            //Notification::send(null,new SendPushNotification($request->title,$request->message,$fcmTokens));

            /* or */

           // auth()->user()->notify(new SendPushNotification($title,$message,$fcmTokens));

            /* or */

            Larafirebase::withTitle($request->title)

                ->withBody($request->message)

                ->sendMessage($fcmTokens);

            return redirect()->back()->with('success','Notification Sent Successfully!!');

        }catch(\Exception $e){

            report($e);

            return redirect()->back()->with('error','Something goes wrong while sending notification.');

        }
    }


    public function sendNotificationrToUser()
    {
       // get a user to get the fcm_token that already sent.
       
       $user = auth()->user();

      FCMService::send(
          $user->fcm_token,
          [
              'title' => 'your title',
              'body' => 'your body',
          ]
      );

    }
    

}
