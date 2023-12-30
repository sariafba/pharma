<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\StatusOrder;
use App\Http\Requests\StoreStatusOrderRequest;
use App\Http\Requests\UpdateStatusOrderRequest;
use App\Models\User;
use Illuminate\Http\Request;

class StatusOrderController extends Controller
{
    use Apitrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(!auth()->user()->role)
            return $this->apiResponse(null, '!!! access only for admins');

        $orders = StatusOrder::with('user')->get();
        return $this->apiResponse($orders, 'all orders');

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreStatusOrderRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        if(!auth()->user()->role)
            return $this->apiResponse(null, '!!! access only for admins');

        $statusOrder = StatusOrder::find($id);

        if (!$statusOrder)
            return $this->apiResponse(null, '!!! wrong status_order id');

        $pharmcist = User::find($statusOrder->user_id);

        $medicines = Order::where('status_orders_id', $statusOrder->id)->with('medicine')->get();

        return $this->apiResponse(['pharmcist name' => $pharmcist->name,
            'status' => $statusOrder->status, 'payment' => $statusOrder->payment,
            'the order' => $medicines],
            'order');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        if(!auth()->user()->role)
            return $this->apiResponse(null, '!!! access only for admins');

        $statusOrder = StatusOrder::find($id);

        if (!$statusOrder)
            return $this->apiResponse(null, '!!! wrong status_order id');

        $request->validate([
            'status' => 'string|in:received,in preparation,sent',
            'payment' => 'string|in:paid,unpaid,shoes'
        ]);

        $statusOrder->update([
            'status' => $request['status'] ?? $statusOrder->status,
            'payment' => $request['payment'] ?? $statusOrder->payment
        ]);

        return $this->apiResponse(null, 'status_order updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StatusOrder $statusOrder)
    {
        //
    }
}
