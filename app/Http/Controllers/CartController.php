<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Medicine;
use Illuminate\Http\Request;


class CartController extends Controller
{
    use Apitrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(int $id)
    {
        $user = auth()->user();

        if($user->role)
            return $this->apiResponse(null, 'access only for pharmacist');

        $medicine = Medicine::find($id);
        if (!$medicine)
            return $this->apiResponse(null, 'no medicine for this id');

        $isInCart = Cart::where('user_id', $user->id)
            ->where('medicine_id', $id)->first();

        if (!$isInCart)
        {

            Cart::create([
                'user_id' => $user->id,
                'medicine_id' => $id,
                'quantity' => 1,
                'total_price' => $medicine->price
            ]);

            return $this->apiResponse(null, 'medicine added to cart successful');

        }
        else
        {
            return $this->apiResponse(null, '!!! medicine already in cart');
        }







    }
    /**
     * Display the specified resource.
     */
    public function show(Cart $cart)
    {
        $user = auth()->user();

        if($user->role)
            return $this->apiResponse(null, 'access only for pharmacist');

        $medicines = Cart::where('user_id', $user->id)->with('medicine')->get();

        return $this->apiResponse($medicines, 'my cart');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $user = auth()->user();
        if ($user->role)
            return $this->apiResponse(null, 'access only for pharmacist');

        $isInCart = Cart::where('user_id', $user->id)
            ->where('medicine_id', $id)->first();

        if (!$isInCart)
        {
            return $this->apiResponse(null, '!!! this medicine not in your cart');
        }

        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $isInCart->update([
            'quantity' => $request['quantity'],
            'total_price' => $isInCart->price * $request['quantity']
        ]);

        return $this->apiResponse(null, 'new quantity '. $request['quantity']);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $user = auth()->user();
        if ($user->role)
            return $this->apiResponse(null, 'access only for pharmacist');

        $isInCart = Cart::where('user_id', $user->id)
            ->where('medicine_id', $id)->first();

        if (!$isInCart)
        {
            return $this->apiResponse(null, '!!! this medicine not in your cart');
        }

        else
        {
            $isInCart->delete();
            return $this->apiResponse(null, 'medicine removed from cart successful');


        }


    }
}
