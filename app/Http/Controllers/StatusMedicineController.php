<?php

namespace App\Http\Controllers;


use App\Models\StatusMedicine;
use App\Http\Requests\StoreStatusMedicineRequest;
use App\Http\Requests\UpdateStatusMedicineRequest;
use Illuminate\Support\Facades\Validator;

class StatusMedicineController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return StatusMedicine::all();
//        return StatusMedicine::sum('quantity');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreStatusMedicineRequest $request)
    {
        $request->validate([
            'quantity'=>'required',
            'Expiration_date'=>'required']);

        $statusMedicine= StatusMedicine::create([
            'quantity' => $request->only('quantity'),
            'Expiration_date' => $request->only('required'),

        ]) ;

        if ($statusMedicine) {
            return $this->apiResponse( 'the status_medicine  defined successfully');
        }

        return $this->apiResponse(null, 'the status_medicine not defined successfully');
    }


    /**
     * Display the specified resource.
     */
    public function show(StatusMedicine $statusMedicine)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(StatusMedicine $statusMedicine)
    {

    }

    /**
     * Update the specified resource in storage.
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
     * Remove the specified resource from storage.
     */
    public function destroy(StatusMedicine $statusMedicine)
    {

    }
}
