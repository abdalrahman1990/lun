<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function success($data=[], $message='success', $code = 200)
    {
        return $this->result('success', $data, $message, $code);
    }


    protected function error($data=[], $message='error', $code = 400)
    {
        return $this->result('error', $data, $message, $code);
    }


    protected function result($status, $data=[], $message='', $code = 200)
    {
        return response()->json([

            'status'  => $status,

            'message' => $message,

            'data'    => $data,

        ], $code);
    }

}
