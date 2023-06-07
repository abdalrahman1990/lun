<?php

namespace App\Http\Controllers;

use App\Mail\Subscribe;
use App\Models\Subscriber;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Collection;
use Illuminate\Notifications\Notification;
use App\Notifications\EmailNotification;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Carbon\Carbon;

class SubscriberController extends ApiController
{

        //----function list of Emails---//

        public function list(Request $request){

            $begin =  $request -> start;
            $date  =  $request ->end;
            $end   =  Carbon::parse($date)->addDay();
    

            $this->validate($request, [
                'start' => 'nullable|date',
                'end'   => 'nullable|date|after:start',
            ]);

        if($begin != null && $end != null){

            $items       = Subscriber::query()
            ->whereBetween('created_at', [$begin, $end])
            ->orderByDesc('id')
            ->get();
            
        }else

            $items       = Subscriber::query()
            ->orderByDesc('id')
            ->get();

            $countEmail  = Subscriber::query()->count();
            $count       = ['countEmails' => $countEmail];
        
            return array("data"=>$items , "count"=>$count);
        }

        

       


        //---- send email only to one email---//

        public function sendEmail(Request $request)
       {
            $email    = $request->email;
            $subject  = $request->subject;
            $greeting = $request->greeting;
            $body     = $request->body;
            // $action   = $request->action;
            $project = [

                'subject'    => $subject,
                'greeting'   => $greeting,
                'body'       => $body,
                // 'actionText' => $action,
                // 'actionURL'  => url('/'),
                'id' => 5
            ];

            \Notification::route('mail', $email)->notify(new EmailNotification($project));
        
           return $this->success();

       }


        //----send email ti all chack emails----//

        public function emailTo_all(Request $request)
        {
            $validator = Validator::make($request->all(), [
                'emails' => 'required'
        ]);

        if ($validator->fails()) {
            return new JsonResponse(['success' => false, 'message' => $validator->errors()], 422);
        }

            $emails = $request->all();
        
            foreach($emails as $email){

            Mail::to($email[])->send(new Subscribe($email));
            }

                return new JsonResponse(
                    [
                        'success' => true,
                        'message' => "Thank you for subscribing"
                    ],
                    200
                );

        }

        //----send notification email to all chacked emails----//

        public function send(Request $request)
        {
            $emails   = $request->emails;
            $subject  = $request->subject;
            $greeting = $request->greeting;
            $body     = $request->body;
        // $action   = $request->action;
            $project = [

                'subject'    => $subject,
                'greeting'   => $greeting,
                'body'       => $body,
                // 'actionText' => $action,
                // 'actionURL'  => url('/'),
                'id' => 57
            ];
        if (is_array($emails) || is_object($emails))
         {
            foreach($emails as $email){
        
                \Notification::route('mail', $email)->notify(new EmailNotification($project));
            } 
        }
        return $this->success();
        }
        



        //--delete only one email according id --//

        public function destroy($id)
        {
            if(!$id){
                return $this->error(['error' => 'product_destroy'], 'Invalid request');
            }

            Subscriber::query()->where('id', $id)->delete();

            return $this->success();
        }



        //--delete all checked emails--//

        public function deleteAll(Request $request)
        {
            $ids = $request->ids;

            Subscriber::whereIn('id',$ids)->delete();
        
           return response()->json(['success'=>"Emails Deleted successfully."]);
        
        }

 
}
