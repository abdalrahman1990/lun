<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ApplicationRequest;
use App\Models\Application;
use Symfony\Component\HttpFoundation\Response;
use CyrildeWit\EloquentViewable\Support\Period;
use App\Models\User;
use Illuminate\Support\Facades\Notification;
use App\Notifications\SendNotification;;
use App\Services\Views\Visitor;
use Illuminate\Support\Collection;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ApplicationController extends ApiController
{
    

    //--list all the app and paginate with count of applications --//

    public function list(Request $request){

        $begin =  $request -> start;
        $date  =  $request ->end;
        $end   =  Carbon::parse($date)->addDay();

        $this->validate($request, [
            'start' => 'nullable|date',
            'end'   => 'nullable|date|after:start',
        ]);

        if($begin != null && $end != null){

            $items =   Application::query()
            ->whereBetween('created_at', [$begin, $end])
            ->orderByDesc('id')
            ->get();
            
        }else

        $items             =   Application::query()
        ->orderByDesc('id')
        ->get();
        $countApplications =   Application::query()->count();
        $openedJob         =   ['countContactUs' => $countApplications]; 
       
        $data = ["data" => $items , "count" => $openedJob];
      
        return response()->json($data);

    }
    

     //--list onle one app in this function based on id--//

    public function index($id){

        if(!$id){
            return $this->error(['error' => 'job_index'], 'Invalid request');
        }

        $app = Application::query()->where('id', $id)->first();
        return $this->success($app);
    }


        //-- update the application as one array in mysql --//
        

    public function update(ApplicationRequest $request, $app_id )
    {

        if(!$app_id){
            return $this->error(['error' => 'Application_update'], 'Invalid request');
        }

        $app = Application::find($app_id);

        if(!$app){
            return $this->error(['error' => 'Application_update'], 'Invalid request');
        }

           $data = $request->all();

           $app->update($data);

        return $this->success();
    }


        //-- Delete the application by ID --//

    public function destroy($id)
    {

        if(!$id){
            return $this->error(['error' => 'product_destroy'], 'Invalid request');
        }

        Application::query()->where('id', $id)->delete();
        return $this->success();
    }


       //-- Delete All the application by IDs --//

    public function deleteAll(Request $request)
    {
        $ids = $request->ids;

        Application::whereIn('id',$ids)->delete();
    
       return response()->json(['success'=>"Contact Us Deleted successfully."]);
        
    }

    
    //-- Show the application Details --//

    public function show()
    {
        $apps =  Application::all();

        foreach($apps as $app) {
            
            $app->unique_views_count = views($app)->unique()->count();
        }
        return $this->success( $app);
    }


}
