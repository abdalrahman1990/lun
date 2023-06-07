<?php

namespace App\Http\Controllers;

use App\Models\C_v;
use App\Models\Job;
use App\Http\Requests\C_vRequest;
use Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Models\User;
use App\Services\FCMService;
use Illuminate\Support\Facades\Notification;
use App\Notifications\SendNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Tymon\JWTAuth\Facades\JWTAuth;
use Carbon\Carbon;

class C_vController extends ApiController
{
        //---list cvs ----//

        public function list(Request $request){

        $daysToAdd = 1;
        $type  =  $request -> type;
        $begin =  $request -> start;
        $date  =  $request ->end;
        $end   =  Carbon::parse($date)->addDay();

        $this->validate($request, [

            'start' => 'nullable|date',
            'end'   => 'nullable|date|after:start',

        ]);

            $collection = new Collection();

        if($type == "specific" && $begin != null && $end != null){

                $cvs = C_v::query()
                ->whereNotNull('job_id')
                ->whereBetween('created_at', [$begin, $end])
                ->orderByDesc('id')
                ->get() ;

            // dd($cvs);

        }elseif($type == "general" && $begin != null && $end != null){

                $cvs = C_v::query()
                ->whereNull('job_id')
                ->whereBetween('created_at', [$begin, $end])
                ->orderByDesc('id')
                ->get();

          // dd($cvs);

        }elseif($type == "general" ){ $cvs = C_v::query()

                ->whereNull('job_id')
                ->orderByDesc('id')
                ->get();

            // dd($cvs);

        }elseif($type == "specific"){
                $cvs = C_v::query()
                ->whereNotNull('job_id')
                ->orderByDesc('id')
                ->get();

            // dd($cvs);
        }

            foreach ($cvs as $cv) {

                $jobCv = Job::select('title as name')
                ->where('id', $cv->job_id)
                ->first();

                $data = [
                    "id"            => $cv->id,
                    "file"          => $cv->file,
                    "status"        => $cv->status,
                    "title"         => $jobCv,
                    "reason"        => $cv->reason,
                    "created_at"    => $cv->created_at,
                    "update_at"     => $cv->updated_at,
                ];

            $collection->push($data);

    }

    return $this->success($collection);

 }


         //-- show sv details--//

        public function index(){

        $id = request('id', 0);

        if(!$id){
            return $this->error(['error' => 'CV_index'], 'Invalid request');
        }

        $c_v = C_v::query()->where('id', $id)->first();

        return $this->success($c_v);
        
        }


        //this function make find the last two cvs by sorted the data and take two//

        public function lastCvs(){

        $cvs = DB::table('c_vs')->select('*')
        ->whereNull('deleted_at')
        ->orderBy('id' , 'desc')
        ->limit(2)
        ->get();

           $collection = new Collection();

           foreach ($cvs as $cv) {

            $jobCv = Job::select('title as name')
            ->where('id', $cv->job_id)
            ->first();

            $data = [
                "id"            => $cv->id,
                "file"          => $cv->file,
                "status"        => $cv->status,
                "title"         => $jobCv,
                "reason"        => $cv->reason,
                "created_at"    => $cv->created_at,
                "update_at"     => $cv->updated_at,
            ];

              $collection->push($data);

         }
            return $this->success($collection);
     }


       

        //this function to update all cv details//

        public function update(C_vRequest $request , $cv_id ){

        if(!$cv_id){
            return $this->error(['error' => 'CV_update'], 'Invalid request');
        }

        $cv = C_v::find($cv_id);

        if(!$cv){
            return $this->error(['error' => 'CV_update'], 'Invalid request');
        }

        if ($request->hasFile('file')) {

            $file		= $request->file('file');
            $filename 	= Str::uuid().'.'.time().'.'.$request->file->getClientOriginalExtension();
            $file       ->storeAs('/cvs', $filename);
        }

            $data        = $request->all();
            $data['file']= $filename;
            $cv          ->update($data);

        return $this->success();
        
        }


        //this function just change status in cvs table//

        public function updateStatus(Request $request,$cv_id){

            $cv = C_v::find($cv_id);

            if(!$cv){
                return $this->error(['error' => 'status_update'], 'Invalid request');
            }

                $cv->status =  $request->status;
                $cv->update();

            return $this->success();

        }


        //this function make you add reason in cvs table//

        public function cvReason(Request $request,$cv_id){

            $cv = C_v::find($cv_id);

            if(!$cv){
                return $this->error(['error' => 'reason_added'], 'Invalid request');
            }

                $cv->reason =  $request->reason;
                $cv->update();

            return $this->success();

        }


        //this function just change job_id in cvs table//

        public function jobCV(Request $request,$cv_id){

            $cv = C_v::find($cv_id);

            if(!$cv){
                return $this->error(['error' => 'job_cv_update'], 'Invalid request');
            }

                $cv->job_id =  $request->job_id;
                $cv->update();

            return $this->success();

        }

        //this function make you download cv when the link clicked//

        // public function downloadFile($file){

        //     $path = storage_path("app/public/cvs/".$file);
        //     //$path = public_path('storage/cvs/'.$file);
        //     //$path = '../storage/app/public/cvs/' . $file;
        //     //dd($path);
        //     $header = [
        //         'Content-Type' => 'application/pdf',
        //     ];

        //     return response()->download($path, $file, $header);
        // }
        

       //delet cv using file name and deleted from storage//

        public function deleteFile($file)
        {
            $file_exist = '../storage/app/public/cvs/' . $file;

            if ($file_exist) {

            // @unlink($file_exist);
                C_v::query()->where('file', $file)->delete();

            } else {

                C_v::query()->where('file', $file)->delete();
                return response()->json(['error' => 'File not exist!']);

            }

            return response()->json(['success' => 'Deleted Successfully.']);
        }



        //delet All cvs using ids array and deleted from storage//

        public function deleteAll(Request $request)
        {

            $ids = $request->ids;

            foreach($ids as $id){

                $file =  C_v::select('file')->where('id', $id)->get();

                $file_exist = '../storage/app/public/cvs/' . $file;

                if ($file_exist) {

                //  @unlink($file_exist);
                    C_v::query()->where('id', $id)->delete();

                } else {

                    C_v::query()->where('id', $id)->delete();
                    return response()->json(['error' => 'File not exist!']);

                }

            }

        return response()->json(['success'=>"Cvs Deleted successfully."]);

    }

   

}
