<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Job;
use App\Models\C_v;
use App\Models\Application;
use App\Models\Subscriber;
use App\Models\Notification;
use Illuminate\Support\Collection;
use Carbon\Carbon;
//use Illuminate\Support\Facades\Response;
use Tymon\JWTAuth\Facades\JWTAuth;

class DashboardController extends ApiController
{

    public function index(){


        $avg_apps     = Application::avg('id');
        $count_apps   = Application::count();

        $avg_emails   = Subscriber::avg('id');
        $count_emails = Subscriber::count();

        $avg_jobs     = Job::avg('id');
        $count_jobs   = Job::count();

        $avg_cvs      = C_v::avg('id');
        $count_cvs    = C_v::count();

        $data = [

            'count_applications'   =>  $count_apps,
            'average_applications' =>  $avg_apps,
            'count_emails'         =>  $count_emails,
            'average_emails'       =>  $avg_emails,
            'count_jobs'           =>  $count_jobs,
            'average_jobs'         =>  $avg_jobs,
            'count_cvs'            =>  $count_cvs,
            'average_cvs'          =>  $avg_cvs,

        ];

        return $this->success($data);
    }


     

    // -- view all notifications-- //
    
    public function listNotification(){

        $items = Notification::select('data as notification','created_at')
        ->orderBy('created_at', 'desc') 
        ->limit(10)
        ->get();
       
    if($items->count() > 0){

       foreach($items as $item){

        $item->notification = json_decode($item->notification);
        Carbon::parse($item->created_at)->diffForHumans();
        $data[] = $item;

       }

    }else{
            
        return response()->json(['error'=>" We Did Not Have Any Notifications."]);
    }
    
        return response()->json(['data'=>$data]);
    
     }


     


}
