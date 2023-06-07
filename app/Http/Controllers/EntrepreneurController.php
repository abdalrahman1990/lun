<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Entrepreneur;
use Illuminate\Support\Collection;
use PDF;
use DB;

class EntrepreneurController extends Controller
{
    public function getData($id){

           //  $Entrepreneur = Entrepreneur::get();

           //  $entrepreneur = json_encode($Entrepreneur,true);

        $entrepreneurs = DB::select('select * from entrepreneurs where id=?',[$id]);

        foreach($entrepreneurs as $entrepreneur){

            $entrepreneur->step1 = json_decode($entrepreneur->step1);
            $data[] = $entrepreneur;
    
        }

        return view('Entrepreneur', ['entrepreneurs'=> $data]);

       // return (['entrepreneurs'=>$data]);

    }

    public function generatePDF()
    {
        $data = [

            'step1' => 'Welcome to CodeSolutionStuff.com',
            'step2' => 'Welcome to CodeSolutionStuff.com',
            'step3' => 'Welcome to CodeSolutionStuff.com',
            'step4' => 'Welcome to CodeSolutionStuff.com',
            'step5' => 'Welcome to CodeSolutionStuff.com',
            'step6' => 'Welcome to CodeSolutionStuff.com',
            'step7' => 'Welcome to CodeSolutionStuff.com',
            'step8' => 'Welcome to CodeSolutionStuff.com',
            'step9' => 'Welcome to CodeSolutionStuff.com',
            'logo'  => 'Welcome to CodeSolutionStuff.com',
            
        ];
        $Entrepreneur = Entrepreneur::get();
          
        $pdf = PDF::loadView('Entrepreneur', $data);
    
        return $pdf->download('Entrepreneur.pdf');
    }
}
