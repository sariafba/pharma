<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Medicine;
use App\Models\Order;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Models\StatusOrder;
use http\Env\Request;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    use Apitrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        if($user->role)
            return $this->apiResponse(null, 'access only for pharmacist');

        $statusOrder = StatusOrder::where('user_id', $user->id)->get();

        if ($statusOrder->isEmpty())
        {
            return $this->apiResponse(null, 'you dont have any order');
        }

        return $this->apiResponse($statusOrder,'your orders');

    }

    public function store()
    {
        $user = auth()->user();
        if ($user->role)
            return $this->apiResponse(null, 'access only for pharmacist');

        // Retrieve medicines from the cart for the given user
        $medicines = Cart::where('user_id', $user->id)->get();

        if($medicines->isEmpty())
        {
            return $this->apiResponse(null, '!!! you dont have any medicine in your cart');
        }
        else
        {
            // Filter the cart items to find those where the required quantity exceeds the available quantity
            $errorMessages = $medicines->filter(function ($medicineInCart) {

                $quantityRequired = $medicineInCart->quantity;
                $medicine = Medicine::find($medicineInCart->medicine_id);

                return $quantityRequired > $medicine->quantity;
            });

            // Transform the filtered items into error messages
            $responseMessages = $errorMessages->map(function ($medicineWithWrongQuantity) {

                $medicine = Medicine::find($medicineWithWrongQuantity->medicine_id);

                return "You ordered more than -{$medicine->quantity}- for medicine: {$medicine->commercial_name} ";
            });

            // Return the API response with the error messages
            if(!$responseMessages->isEmpty())
                return $this->apiResponse(null, $responseMessages->values()->toArray());
        }

        $statusOrder = StatusOrder::create([
            'user_id' => $user->id,
        ]);

        for ($i=0; $i<$medicines->count(); $i++)
        Order::create([
            'status_orders_id' => $statusOrder->id,
            'medicine_id' => $medicines[$i]->id,
            'required_quantity' => $medicines[$i]->quantity
        ]);

        Cart::where('user_id', $user->id)->delete();

        return $this->apiResponse(null, 'your order received');


        //my code before use chat gpt --dont delete--
//        $medicines = Cart::where('user_id', $user->id)->get();
//
//        $errorMessage = [];
//        for ($i=0; $i<$medicines->count(); $i++)
//        {
//            $quantityRequired = $medicines[$i]->quantity;
//            $medicine = Medicine::find($medicines[$i]->medicine_id);
//
//            if ($quantityRequired > $medicine->quantity)
//                $errorMessage[] = $medicine;
//
//        }
//
//        for ($i=0; $i<count($errorMessage); $i++)
//        $responseMessage[] = 'you order more than -' . $errorMessage[$i]->quantity .
//            '- for medicine: '. $errorMessage[$i]->commercial_name;
//
//        return $this->apiResponse(null, $responseMessage);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {

        $user = auth()->user();
        if($user->role)
            return $this->apiResponse(null, 'access only for pharmacist');

        $statusOrder = StatusOrder::find($id);

        if (!$statusOrder)
            return $this->apiResponse(null, '!!! wrong order id');

        if($statusOrder->user_id != $user->id)
            return $this->apiResponse(null,'!!! not your order');

        $medicines = Order::where('status_orders_id', $statusOrder->id)->with('medicine')->get();

        return $this->apiResponse(['status' => $statusOrder->status, 'payment' => $statusOrder->payment,
                'the order' => $medicines],
                'my order');


    }




    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrderRequest $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }
}
