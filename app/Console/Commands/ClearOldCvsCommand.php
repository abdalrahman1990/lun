<?php

namespace App\Console\Commands;

use App\Models\C_v;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
//use Illuminate\Support\Facades\DB;


class ClearOldCvsCommand extends Command
{
   
    protected $signature = 'clear:cvs';
  
    protected $description = 'Delete All Cvs';

    public function __construct()
    {
        parent::__construct();
    }


        public function handle()
        {
            $month = Carbon::now()->format('m');
            $year  = Carbon::now()->format('Y');

            $cvs = C_v::query()->withTrashed()
            ->whereYear("created_at", "!=", $year)
            ->whereMonth("created_at", "!=", $month)
            ->whereNotNull('deleted_at')
            ->get();
           
            foreach($cvs as $cv){
    
                $file = $cv->file;

                if(file_exists(storage_path("app/public/cvs/".$file))){

                    @unlink(storage_path("app/public/cvs/".$file));

                    C_v::query()->where('file', $file)->forceDelete();

                }else{
                    return response()->json(['error' => 'File not exist!']);

                    }

                $this->info( " This CV Deleted \n  $cv->file  \n "  );
            }

        }



    }

    


