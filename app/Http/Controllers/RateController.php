<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RateRequest;
use App\Models\Rate;
use Illuminate\Support\Collection;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\DB;
use carbon\carbon;

class RateController extends ApiController
{
     // -- view all reviews-- //
     public function list(){

        $items = Rate::all();

        $collection = new Collection();

        foreach($items  as $item ){
  
            $data = [
  
                "id"           => $item->id,
                "name"         => $item->name,
                "rate"         => $item->rate,
                "postion"      => $item->postion,
                "comment"      =>$item->comment,
                "created_at"   => Carbon::parse($item->created_at)->diffForHumans(),
                
            
            ];
  
            $collection->push($data);
        }
  
        return response()->json([ 'data' => $collection]);

     }


     // -- view top reviews-- //

     public function topRating(){

      $items = DB::table('rates')->select('*')
      ->orderBy('rate' , 'desc')
      ->limit(3)
      ->get();

      $collection = new Collection();

      foreach($items  as $item ){

          $data = [

              "id"           => $item->id,
              "name"         => $item->name,
              "rate"         => $item->rate,
              "postion"      => $item->postion,
              "comment"      =>$item->comment,
              "created_at"   => Carbon::parse($item->created_at)->diffForHumans(),
              
          
          ];

          $collection->push($data);
      }

      return response()->json([ 'data' => $collection]);
     }


     //-- delete review--//

     public function destroy($id)
     {
        if(!$id){

            return $this->error(['error' => 'rating_destroy'], 'Invalid request');
        }
        Rate::query()->where('id', $id)->delete();
        return $this->success();
     }


     

}
