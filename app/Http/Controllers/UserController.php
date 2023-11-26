<?php

namespace App\Http\Controllers;

use App\Models\Pharmacist;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Apitrait;

class UserController extends Controller
{
   use Apitrait;

    //create new account

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'phone' => 'required|unique:users,phone',
            'password' => 'required|confirmed',
        ],
           ['phone.unique' => ['code' => 'ERR006', 'message' => 'This phone is already in use.'],
        ]);

        $user = User::create([
            'name' => $request->input('name'),
            'phone' => $request->input('phone'),
            'password' => bcrypt($request->input('password')),
        ]);

        Pharmacist::create([
            'user_id' => $user->id
        ]);

        $token = $user->createToken('myapp-token')->plainTextToken;
        $response = [
            'user' => $user,
            'token' => $token,
        ];

        return $this->apiResponse($response, 'register successfully');
    }

    //logout and delete token

    public function logout( Request $request){
        Auth()->user()->tokens()->delete();

        return $this->apiResponse(null,'logout successfully');
    }

    //login

    public function login( Request $request){
         $request->validate([
            'phone'=> 'required',
            'password'=> 'required'
        ]);

        // check phone and password

        $user = User::where('phone', $request->only('phone'))->first();

        if (!$user ){

            return $this->apiResponse(null,'Wrong phone number');

        }

        if ( !Hash::check ($request->input('password'),$user->password)){

            return $this->apiResponse(null,'Wrong password');
        }

        $token = $user->createToken('myapp-token')->plainTextToken;
        $response = [
            'user'=>$user,
            'token'=>$token
        ];

        return $this->apiResponse($response,'login successfully');
    }
}
