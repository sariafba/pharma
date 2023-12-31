<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Apitrait;
use App\Models\Pharmacist;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
   use Apitrait;

    //create new account

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'phone' => 'required|unique:users,phone',
            'password' => 'required',
        ], [
            'phone.unique' => ['code' => 'ERR006', 'message' => 'This phone is already in use.'],
        ]);

        if ($validator->fails()) {
            return $this->apiResponse(null, $validator->getMessageBag(), 400);
        }

        $user = User::create([
            'name' => $request->input('name'),
            'phone' => $request->input('phone'),
            'password' => bcrypt($request->input('password')),
        ]);

        $token = $user->createToken('myapp-token')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token,
        ];

        return response($response, 201);
    }

    //logout and delete token

    public function logout( Request $request){
        Auth()->user()->tokens()->delete();

        return $this->apiResponse(null,'logout successfully');
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
    public function index()
    {
        return $this->apiResponse(User::all(),'User fetched successfully');
    }
}
