<?php

namespace App\Http\Controllers;

use App\Models\FavoritMedicine;
use App\Http\Requests\StoreFavoritMedicineRequest;
use App\Http\Requests\UpdateFavoritMedicineRequest;

class FavoritMedicineController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(StoreFavoritMedicineRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(FavoritMedicine $favoritMedicine)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FavoritMedicine $favoritMedicine)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFavoritMedicineRequest $request, FavoritMedicine $favoritMedicine)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FavoritMedicine $favoritMedicine)
    {
        //
    }
}
