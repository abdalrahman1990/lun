<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\JobRequest ;
use Illuminate\Http\Response;
use App\Models\Job;
use App\Models\C_v;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Tymon\JWTAuth\Facades\JWTAuth;
use Carbon\Carbon;

class JobController extends ApiController
{

     //-- show all jobs --//

     public function list(Request $request){
        

        $begin =  $request->start;
        $date  =  $request ->end;
        $end   =  Carbon::parse($date)->addDay();


        $this->validate($request, [
            'start' => 'nullable|date',
            'end'   => 'nullable|date|after:start',
           ]); 

        if($end != null && $begin != null){

            $jobs = Job::query()
            ->whereBetween('created_at', [$begin, $end])
            ->orderByDesc('id')
            ->get() ;

        }else

            $jobs = Job::query()
            ->orderByDesc('id')
            ->get() ;

        $collection = new Collection();

        $availablejobs = Job::all()->count();

        foreach ($jobs as $job) {

        $count_cv = C_v::where('job_id', $job->id)
        ->count();

        $title    = ["name" => $job->title];

        $data = [
            "id"            => $job->id,
            "title"         => $title,
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
            "image"         => 'https://i.imgur.com/tZxzgH5.jpg',
            "created_at"    => $job->created_at,
            "update_at"     => $job->updated_at,
            "count_cv"      => $count_cv,
        ];

        $collection->push($data); 

      }

        $openedJob = ['count_available_jobs' => $availablejobs];

        return array("data"=>$collection , "count"=>$openedJob);
     }


     //-- only one job --//
    
     public function index(){

        $id = request('id', 0);

        if(!$id){
            return $this->error(['error' => 'job_index'], 'Invalid request');
        }

        $job = Job::query()->where('id', $id)->first();

        return $this->success($job);
     }

    
     //-- general jobs --//

     public function generalJobs(){
        $job_id = null;
        $cvs = C_v::query()->where('job_id', $job_id)->paginate(10);

        return $this->success($cvs);
     }


     //-- all cvs for job --//

     public function cvsJob($job_id){

        if(!$job_id){

            return $this->error(['error' => 'job_cvs'], 'Invalid request');
        }

        $cvsJobs = C_v::where('job_id', $job_id)->paginate(10);

        return $this->success($cvsJobs);
     }


     //-- all available jobs --//

     public function availableJobs(){

        $jobs = Job::where('status', 'Opened')->count();

        return $this->success($jobs);
     }


     //--Store a new blog post--//

     public function store(JobRequest $request){ 

        if ($request->hasFile('image')) {

            $image 		   = $request->file('image');
            $filename 	   = Str::uuid().'.'.time().'.'.$request->image->getClientOriginalExtension();
            $image         ->storeAs('/images', $filename);
        }
            $data          = $request->all();
            $data['image'] = isset($filename)?$filename:null;
            $job           = Job::create($data);

        if(!$job){

            return $this->error(['error' => 'job_store'], 'Invalid request');

        }

       return $this->success();

    }


    //-- update job --//

    public function update(Request $request, $job_id )
    {

        if(!$job_id){

            return $this->error(['error' => 'job_update'], 'Invalid request');
        }

        $job = Job::find($job_id);

        if(!$job){
            return $this->error(['error' => 'job_update'], 'Invalid request');
        }

        if ($request->hasFile('image')) {

            $image 		= $request->file('image');
            $filename 	= Str::uuid().'.'.time().'.'.$request->image->getClientOriginalExtension();
            $image      ->storeAs('/images', $filename);
        }

           $data = $request->all();
           $data['image'] = 'https://i.imgur.com/tZxzgH5.jpg';
           $job->update($data);

        return $this->success();
    }

   

     //-- list job title--//

     public function jobTitle(Request $request ){

        $filter = $request->filter;

        if($filter == "id"){

            $title = DB::table('jobs')->select('id','title as name')->whereNull('deleted_at')->get();

        }elseif($filter == "title"){

            $title = DB::table('jobs')->select('title as name')->whereNull('deleted_at')->get();
          
        }else{

            return $this->error(['error' => 'please choose filter'], 'Invalid request');
        }

        if(!$title){

            return $this->error(['error' => 'job_title_index'], 'Invalid request');
        }
        return $this->success($title);
    }

    
    //-- delete only one job --//

    public function destroy($id)
    {
        if(!$id){

            return $this->error(['error' => 'product_destroy'], 'Invalid request');
        }

        $cvs = C_v::where('job_id', $id)->get();

        foreach($cvs as $cv){

            $cv->update(['job_id' => NULL]);
        }
        
        Job::query()->where('id', $id)->delete();

        return $this->success();
    }


    //-- delete checked jobs --//
    
    public function deleteAll(Request $request)
    {   

    $ids = $request->ids;

    Job::whereIn('id',$ids)->delete();

   return response()->json(['success'=>"Jobs Deleted successfully."]);

   }


}
