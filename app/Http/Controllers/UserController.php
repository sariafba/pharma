<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    //create new account

    public function register( Request $request){

        $fields = $request->validate([
            'name'=> 'required|string',
            'phone'=> 'required|unique:users,phone',
            'password'=> 'required'

        ]);

        $user = User::create([
            'name'=> $fields['name'],
            'phone'=> $fields['phone'],
            'password'=>bcrypt($fields['password'])
        ]);


        $token = $user->createToken('myapp-token')->plainTextToken;
        $response = [
            'user'=>$user,
            'token'=>$token
        ];


        return response ($response,201);
    }

    //logout and delete token

    public function logout( Request $request){
        auth()->user()->tokens()->delete();

        return [
            'message'=> ' logout '
        ];
    }

    //login


    public function login( Request $request){
        $fields = $request->validate([
            'phone'=> 'required',
            'password'=> 'required'
        ]);

        // check phone and password

        $user = User::where('phone',$fields['phone'])->first();

        if (!$user ){

            return response([

                'message'=>'Wrong phone number'],401);

        }

        if ( !Hash::check ($fields['password'],$user->password)){
            return response([

                'message'=>'Wrong password'],401);

        }


        $token = $user->createToken('myapp-token')->plainTextToken;
        $response = [
            'user'=>$user,
            'token'=>$token
        ];

        return response ($response,201);
    }
}
