<?php

namespace App\Http\Controllers;

use App\Models\Pharmacist;
use App\Http\Requests\StorePharmacistRequest;
use App\Http\Requests\UpdatePharmacistRequest;

class PharmacistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->apiResponse(Pharmacist::all(),'pharmacist fetched successfully');
    }

    /**
     * Show the form for creating a new resource.
     */
    public static function create($id)
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePharmacistRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
      //show for pharmacist
      if(auth()->user()->role)
          return $this->apiResponse(Pharmacist::find($id), 'pharmacist fetched successfully');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pharmacist $pharmacist)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePharmacistRequest $request, Pharmacist $pharmacist)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pharmacist $pharmacist)
    {
        //
    }
}
