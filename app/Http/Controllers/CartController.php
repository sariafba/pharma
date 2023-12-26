<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Medicine;
use Illuminate\Http\Request;
use function MongoDB\BSON\toJSON;


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

        $medicine = Cart::where('user_id', $user->id)
            ->where('medicine_id', $id)->first();

        if(!$medicine)
        {
            Cart::create([
                'user_id' => $user->id,
                'medicine_id' => $id
            ]);

            return $this->apiResponse(null, 'medicine added to cart successful');
        }
        else
        {
            $medicine->delete();

            return $this->apiResponse(null, 'medicine removed from cart successful');
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
    public function update(UpdateCartRequest $request, Cart $cart)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cart $cart)
    {
        //
    }
}
