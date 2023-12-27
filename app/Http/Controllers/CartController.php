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
    public function store(int $id, Request $request)
    {
        $user = auth()->user();

        if ($user->role) {
            return $this->apiResponse(null, 'Access only for pharmacist');
        }

        $medicine = Medicine::find($id);

        if (!$medicine) {
            return $this->apiResponse(null, 'No medicine for this id');
        }

        $Cart = Cart::where('user_id', $user->id)->where('medicine_id', $id)->first();

        if (!$Cart) {

            $quantityToAdd = $request->input('quantity');

            if ($medicine->quantity >= $quantityToAdd) {

                $medicinePrice = $medicine->price ?? 0;
                $totalPrice = $medicinePrice * $quantityToAdd;


                Cart::create([
                'user_id' => $user->id,
                'medicine_id' => $id,
                'quantity' => $quantityToAdd,
                'price' => $totalPrice,
            ]);
                $medicine->decrement('quantity', $quantityToAdd);

                return $this->apiResponse(null, 'Medicine added to cart successfully');
            }
            else {
                return $this->apiResponse(null, 'Not enough quantity in stock');
            }
        } else {
            return $this->apiResponse(null, 'Medicine already in cart');
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
        if(!auth()->user()->role)
            return $this->apiResponse(null, 'access only for admin');

        $medicine = Medicine::find($id);

        if (!$medicine)
            return $this->apiResponse(null, 'No medicine found with the specified ID');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $user = auth()->user();
        if ($user->role)
            return $this->apiResponse(null, 'access only for pharmacist');


        $medicine = Medicine::find($id);

        if (!$medicine) {
            return $this->apiResponse($medicine, 'the medicine not found');
        }
        $cart = Cart::where('user_id', $user->id)
            ->where('medicine_id', $id)->first();

        if ($cart) {
            $result = $cart->delete();
            if ($result) {
                return $this->apiResponse(null, 'the medicine deleted from favourite');
            }
        }
    }
}
