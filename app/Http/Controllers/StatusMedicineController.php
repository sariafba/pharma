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
        $validator = Validator::make($request->all(), [
            'quantity'=>'required',
            'Expiration_date'=>'required']);
        if ($validator->fails()) {
            return $this->apiResponse(null, $validator->errors(), 400);
    }

        $status_medicine = StatusMedicine::create($request->all());

        if ($status_medicine) {
            return $this->apiResponse( 'the status_medicine  defined successfully', 201);
        }

        return $this->apiResponse(null, 'the status_medicine not defined successfully', 400);
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
        $validator = Validator::make($request->all(), [
            'quantity'=>'required',
            'Expiration_date'=>'required'

        ]);

        if ($validator->fails()) {
            return $this->apiResponse(null, $validator->errors(), 400);
        }
        $statusMedicine = StatusMedicine::find($statusMedicine);
        if (!$statusMedicine) {
            return $this->apiResponse($statusMedicine, 'the post not found', 404);
        }
        $statusMedicine->update($request->all());
        if ($statusMedicine) {
            return $this->apiResponse($statusMedicine, 'the post updated', 201);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StatusMedicine $statusMedicine)
    {

    }
}
