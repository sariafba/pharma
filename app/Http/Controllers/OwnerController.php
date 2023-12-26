<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use App\Models\Owner;
use App\Http\Requests\StoreOwnerRequest;
use App\Http\Requests\UpdateOwnerRequest;
use App\Models\StatusMedicine;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class OwnerController extends Controller
{
    use Apitrait;

    //login
    public function login(Request $request)
    {

        $validatedData = $request->validate([
                'phone' => 'required',
                'password' => 'required'
            ]
        );

        $admin = User::where('phone', $validatedData['phone'])->first();

        if (!$admin || !$admin->role == 1)
            return response([

                'message'=>'you are not admin'],401);

        if (!Hash::check($validatedData['password'], $admin->password))
            return response([

                'message'=>'Wrong password'],401);

        $token = $admin->createToken('myapp-token')->plainTextToken;

        return $this->apiResponse(['token' => $token], 'logged in');
    }

}



