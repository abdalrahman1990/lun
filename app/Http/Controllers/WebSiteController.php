<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ApplicationRequest;
use Symfony\Component\HttpFoundation\Response;
use CyrildeWit\EloquentViewable\Support\Period;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Notification;
use App\Notifications\EmailNotification;
use App\Notifications\SendNotification;
use App\Notifications\SendPushNotification;
use App\Services\FCMService;
use App\Http\Requests\C_vRequest;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;
use App\Mail\Subscribe;
use App\Models\Subscriber;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\RateRequest;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\C_v;
use App\Models\Job;
use App\Models\File;
use App\Models\Rate;
use App\Models\Visitor;
use App\Models\Application;
use App\Models\Entrepreneur;
use Carbon\Carbon;
use Str;



class WebSiteController extends Controller
{
   
    //---- subscribe function---//

    public function subscribe(Request $request)
    {
    $validator = Validator::make($request->all(), [
        'email' => 'required|email'
    ]);

    if ($validator->fails()) {
        return new JsonResponse(['success' => false, 'message' => $validator->errors()], 422);
    }

    $email = $request->all()['email'];
        $subscriber = Subscriber::create([
            'email' => $email
        ]
    );

    $sentData = [
        'name'   => 'Admin',
        'body'   => 'You received Contact us.',
        'thanks' => 'Thank you',
        'Text' => 'Check Out New Email Added',
        'Url'  => url('/'),
        'id'   => 30
    ];

    $admins = User::query()->get();

        foreach($admins as $admin){

         $id =  $admin->id;  

        $sendNotifications = User::findOrFail($id);

        }
        $fcmTokens = $sendNotifications->fcm_token;
        $sendNotifications->notify(new SendNotification($sentData, $title = 'You Have New Email', $message = 'please check it', $fcmTokens));

    if ($subscriber) {
        //Mail::to($email)->send(new Subscribe($email));
        return new JsonResponse(
            [
                'success' => true,
                'message' => "Thank you for subscribing"
            ],
            200
        );
    }

    }


    //--add review--//

    public function storeRate(RateRequest $request){

        $data  =  $request->all();
  
        $rate   =  Rate::create($data);
  
          if(!$rate){
  
            return response()->json(['error' => 'storeRate.']);

          }
  
          return response()->json(['success' => ' Successfully.']);
  
        }


        
     //-- add the application as one array in mysql --//

    public function storeApp(ApplicationRequest $request){

            $data = $request->all();

            $app  = Application::create($data);

        if(!$app){

            return response()->json(['error' => 'Application_store']);
        }

        $sentData = [
            'name'   => 'Admin',
            'body'   => 'You received Contact us.',
            'thanks' => 'Thank you',
            'Text' => 'Check Out New Contact us Added',
            'Url'  => url('/'),
            'id'   => 30
        ];

        $admins = User::query()->get();

        foreach($admins as $admin){

         $id =  $admin->id;  

        $sendNotifications = User::findOrFail($id);

        }
        $fcmTokens = $sendNotifications->fcm_token;
        $sendNotifications->notify(new SendNotification($sentData, $title = 'You Have New Contact us', $message = 'please check it', $fcmTokens));

        return response()->json(['success'=>" Your Application Saved Successfully."]);

    }


    
    
      //--store function allow you to add pdf cv--//

      public function storeCv(C_vRequest $request){

            if ($request->hasFile('file')) {
                $cv 		  = $request->file('file');
                $filename 	  = Str::uuid().'.'.time().'.'.$request->file->getClientOriginalExtension();
                $cv           ->storeAs('/cvs', $filename);
            }
                $data         = $request->all();
                $data['file'] = $filename;
                $insert       = C_v::create($data);

            if(!$insert){

                return response()->json(['error' => 'Invalid request.']);

            }

            $sentData = [
                'name'   => 'Admin',
                'body'   => 'You received CV.',
                'thanks' => 'Thank you',
                'Text' => 'Check Out New CV Added',
                'Url'  => url('/'),
                'id'   => 30
            ];

               $admins = User::query()->get();

                foreach($admins as $admin){

                 $id =  $admin->id;  

                 $sendNotifications = User::findOrFail($id);

                }
                $fcmTokens = $sendNotifications->fcm_token;
                $sendNotifications->notify(new SendNotification($sentData, $title = 'You Have New Cv', $message = 'please check it', $fcmTokens));
                
            return response()->json(['success'=>" Your Cv Successfully."]);

        }


        //-- all available jobs --//

        public function availableList(){

            $jobs = Job::where('status', 'Opened')->get();

            $collection = new Collection();

            foreach($jobs as $job){

                $data = [

                    "id"            => $job->id,
                    "title"         => $job->title,
                    "type"          => $job->type,
                    "hierarchical"  => $job->hierarchical,
                    "salary"        => $job->salary,
                    "address"       => $job->address,
                    "experience"    => $job->experience,
                    "description"   => $job->description,
                    "requirement"   => $job->requirement,
                    "status"        => $job->status,
                    "start_time"    => $job->start_time,
                    "end_time"      => $job->end_time,
                    "image"         => $job->image,
                    "created_at"    => Carbon::parse($job->created_at)->diffForHumans(),
                    "update_at"     => $job->updated_at,
                
                ];

                $collection->push($data);
            }
            
            return response()->json([ 'data' => $collection]);
            
        }


        //-- only one job --//
            
        public function getJob(){

            $id = request('id', 0);

            if(!$id){
                return response()->json(['error'=>" Invalid request."]);
            }

            $job = Job::query()->where('id', $id)->first();
            
           $data = [
            "id"            => $job->id,
            "title"         => $job->title,
            "type"          => $job->type,
            "hierarchical"  => $job->hierarchical,
            "salary"        => $job->salary,
            "address"       => $job->address,
            "experience"    => $job->experience,
            "description"   => $job->description,
            "requirement"   => $job->requirement,
            "status"        => $job->status,
            "start_time"    => $job->start_time,
            "end_time"      => $job->end_time,
            "image"         => $job->image,
            "created_at"    => Carbon::parse($job->created_at)->diffForHumans(),
            "update_at"     => $job->updated_at,
           
        ];
            return response()->json([ 'data' => $data]);
            
        }

        //this function make you download cv when the link clicked//

        public function downloadFile($file){

            //$path = public_path('storage/cvs/'.$file);
            $path = '../storage/app/public/cvs/' . $file;

            //dd($path);

            $header = [
                'Content-Type' => 'application/pdf',
            ];

            return response()->download($path, $file, $header);
        }


        public function listOf_title(){

           $titles = DB::table('jobs_title')->select('title as name')->get();
           return response()->json([ 'data' => $titles]);
        }
      

        //-- to get device ip and save it in database --//

        public function getIP(Request $request)
        {

            $ipaddress = $request->ip();

            $visitor = Visitor::Create(['ip' => $ipaddress]);

            if(!$ipaddress){

                return $this->error(['error' => 'ip_store'], 'Invalid request');

            }

          return $this->success($ipaddress);

        }


        public function storeSteps(Request $request){

                $data = [
                
                    'step1' => $request->step1,
                    'step2' => $request->step2,
                    'step3' => $request->step3,
                    'step4' => $request->step4,
                    'step5' => $request->step5,
                    'step6' => $request->step6,
                    'step7' => $request->step7,
                    'step8' => $request->step8,
                    'step9' => $request->step9,
                    
                ];

                if ($request->hasFile('logo')) {

                    $image 		   = $request->file('logo');
                    $filename 	   = Str::uuid().'.'.time().'.'.$request->logo->getClientOriginalExtension();
                    $image         ->storeAs('/logos', $filename);
                    $data['logo']  = $filename;
                }

                $entrepreneurs =   Entrepreneur::create($data);

    
               if($request->hasFile('photos')){

                    $allowedfileExtension = ['pdf','jpg','jpeg','png','docx'];

                    $files = $request->file('photos');

                    foreach($files as $file){

                    $filename = $file->getClientOriginalName();
                    $extension = $file->getClientOriginalExtension();
                    $check=in_array($extension,$allowedfileExtension);

                    }
                    //dd($check);
                   
                    if($check){

                  //  $entrepreneurs =   Entrepreneur::create($data);

                    foreach ($request->photos as $photo) {

                    $filename = $photo->store('photos');

                    File::create([ 'filename' => $filename , 'entrepreneur_id' => $entrepreneurs->id]);
                    
                    }
            
                    echo "Upload Successfully";
                }
                else
                {
                echo '<div class="alert alert-warning"><strong>Warning!</strong> Sorry Only Upload png , jpg , doc</div>';
                }

            }
            

        }

       
    }






