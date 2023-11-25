<?php

namespace App\Http\Controllers;


use http\Env\Response;

trait Apitrait
{
    public  function apiResponse($data,$message){
        return response()->json  ([
            'data'=>$data,
            'message'=>$message,
        ]);

    }
}
