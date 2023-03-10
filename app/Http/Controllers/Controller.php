<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function sendResponse(String $message,mixed $data = array(),int $status = 200)
    {
        return response()->json(['success'=>true,'data'=>$data,'message'=>$message],$status);
    }

    public function sendError(String $message,int $status = 400){
        return response()->json(['success'=>false,'data'=>[],'message'=>$message],$status);
    }
}
