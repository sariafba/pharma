<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use App\Models\Owner;
use App\Http\Requests\StoreOwnerRequest;
use App\Http\Requests\UpdateOwnerRequest;
use App\Models\StatusMedicine;
use App\Models\User;
use Illuminate\Http\Request;
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
            return $this->apiResponse(null, 'you are not Admin');

        if (!Hash::check($validatedData['password'], $admin->password))
            return $this->apiResponse(null, 'wrong password');

        $token = $admin->createToken('myapp-token')->plainTextToken;

        return $this->apiResponse(['token' => $token], 'logged in');
    }

    //create medicine first time
    public function create(Request $request)
    {
        $validatedData = $request->validate([
            'commercial_name' => 'required|string|unique:medicines,commercial_name',
            'scientific_name' => 'required|string',
            'manufacture_company' => 'required|string',
            'category_id' => 'required|integer',
            'price' => 'required|integer',
            'quantity' => 'required|integer',
            'expiration_date' => 'required|date_format:Y-m-d'
        ]);

        $medicine = Medicine::create([
            'commercial_name' => $validatedData['commercial_name'],
            'scientific_name' => $validatedData['scientific_name'],
            'manufacture_company' => $validatedData['manufacture_company'],
            'price' => $validatedData['price'],
            'category_id' => $validatedData['category_id']
        ]);

        StatusMedicine::create([
            'medicine_id' => $medicine->id,
            'quantity' => $validatedData['quantity'],
            'expiration_date' => $validatedData['expiration_date']
        ]);

        $medicine->quantity = Medicine::withSum('statusMedicines', 'quantity')->find($medicine->id) ?? 0;

        return $this->apiResponse(null,'medicine stored successfully');

    }

    //store new quantity
    public function store(Request $request)
    {

    }
}



