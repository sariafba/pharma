<?php

namespace App\Http\Controllers;


use http\Env\Response;

trait Apitrait
{
    public  function apiResponse($data,$message,$status){
        return response()->json  ([
            'data'=>$data,
            'message'=>$message,
            'status'=>$status
        ]);

    }
}
