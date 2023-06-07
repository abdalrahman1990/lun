<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests\VisitorRequest;
use App\Models\Visitor;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
class VisitorController extends ApiController
{

   
    //-- this is dynamic funcation that make you count visitor and order by monthly--//

    public function getVisitors(VisitorRequest $request)
    {

        $begin =  $request->start;
        $date  =  $request ->end;
        $end   =  Carbon::parse($date)->addDay();
 

        if($end != null && $begin != null){

            $months = DB::table('visitors')
            ->whereRaw("created_at between '$begin' and '$end'")
            ->groupBy(DB::raw('DATE_FORMAT(created_at,"%d-%m-%Y")'))
            ->orderBy(DB::raw('DATE_FORMAT(created_at,"%d-%m-%Y")'))
            ->get([
                DB::raw('DATE_FORMAT(created_at,"%d-%m-%Y") as data'),
                DB::raw('COUNT(ip) as count_visitors')
            ]); 

        }else{

            $months = Visitor::select(
                DB::raw("DATE_FORMAT(created_at,'%m') as month"),
                DB::raw('COUNT(ip) as count_visitors'),
                DB::raw('max(created_at) as createdAt'))
               ->orderBy('createdAt', 'asc')
               ->groupBy('month')
               ->get(); 
        }

        if(!$months){

            return $this->error(['error' => 'get_visitor'], 'Invalid request');
        }

       return $this->success($months);

    }

}
