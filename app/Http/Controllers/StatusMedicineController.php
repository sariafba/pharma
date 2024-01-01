<?php

namespace App\Http\Controllers;


use App\Models\Medicine;
use App\Models\StatusMedicine;
use App\Http\Requests\StoreStatusMedicineRequest;
use App\Http\Requests\UpdateStatusMedicineRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StatusMedicineController extends Controller
{
    use Apitrait;

    /**
     * Display a listing of the resource. !!!!!
     */
    public function index()
    {
        return StatusMedicine::all();
//        return StatusMedicine::sum('quantity');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $id)
    {
        //access just for admin
        if(!auth()->user()->role)
            return $this->apiResponse(null, 'access only for admin');

        $medicine = Medicine::find($id);

        if (!$medicine)
            return $this->apiResponse(null, 'No medicine found with the specified ID');

        $validatedDAta = $request->validate([
            'quantity' => 'required|integer',
            'expiration_date' => 'required|date_format:Y-m-d'
        ]);

        $statusMedicine = StatusMedicine::create([
            'medicine_id' => $medicine->id,
            'quantity' => $validatedDAta['quantity'],
            'expiration_date' => $validatedDAta['expiration_date'],
             'report_quantity' =>  $validatedDAta['quantity']
        ]) ;

        $medicine->update([
            'quantity' => $medicine->statusMedicines()->sum('quantity')
        ]);

        //wrong way, search for why in future
//        $medicine->quantity = StatusMedicine::where('medicine_id', $medicine->id)->sum('quantity');



        if($statusMedicine)
            return $this->apiResponse($statusMedicine, 'new quantity stored successfully');

    }


    /**
     * Display the specified resource.  !!!!
     */
    public function show(StatusMedicine $statusMedicine)
    {
        //
    }


    /**
     * Update the specified resource in storage. !!!!
     */
    public function update(UpdateStatusMedicineRequest $request, StatusMedicine $statusMedicine)
    {
        $request->validate([
            'quantity'=>'required',
            'Expiration_date'=>'required']);

        $statusMedicine = StatusMedicine::find($statusMedicine);
        if (!$statusMedicine) {
            return $this->apiResponse($statusMedicine, 'the post not found');
        }

        $statusMedicine= StatusMedicine::update([
            'quantity' => $request->only('quantity'),
            'Expiration_date' => $request->only('required'),

        ]) ;

        if ($statusMedicine) {
            return $this->apiResponse($statusMedicine, 'the post updated');
        }
    }

    /**
     * Remove the specified resource from storage. !!!!
     */
    public function destroy(StatusMedicine $statusMedicine)
    {


        $expiredRecords = StatusMedicine::where('expiration_date', '<', now())->get();

        foreach ($expiredRecords as $record) {
            $record->delete();
        }

        return response()->json(['message' => 'Expired records deleted successfully']);

    }
}
