<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use App\Http\Requests\StoreMedicineRequest;
use App\Http\Requests\UpdateMedicineRequest;

class MedicineController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Medicine::all();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'commercial_name' => 'required',
            'scientific_name' => 'required',
            'manufacture_company' => 'required',
            'price' => 'required'
            // 'description'=> 'required'
        ]);


        return Medicine::create($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Medicine::find($id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Medicine $medicine)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $medicine = Medicine::find($id);
        if ($medicine !== null) {

            $medicine->update($request->all());
            return response([

                'massage' => 'updated',
                'medicine' => $medicine], 201);
        } else {
            return response([

                'message' => 'not found'], 401);
        }

        return $medicine;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        $medicine = Medicine::find($id);
        if ($medicine !== null && $medicine->phone == auth()->user()->phone) {

            $medicine->delete();

            return response([

                'message' => 'deleted'], 201);
        } else {
            return response([

                'message' => 'not found'], 401);
        }

    }

    public function search($name)

    {
        $result1 = Medicine::Where('commercial_name', 'like', '%' . $name . '%')
            ->orwhere('scientific_name', 'like', '%' . $name . '%')
            ->get();
        if ($result1) {
            return $result1;}

        else {
            return response([
                'message' => 'not found'], 404);
        }
    }
}
