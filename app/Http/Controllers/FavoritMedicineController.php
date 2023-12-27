<?php

namespace App\Http\Controllers;

use App\Models\FavoritMedicine;
use App\Http\Requests\StoreFavoritMedicineRequest;
use App\Http\Requests\UpdateFavoritMedicineRequest;
use App\Models\Medicine;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FavoritMedicineController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    use Apitrait;

    public function index()
    {

        return $this->apiResponse(FavoritMedicine::all(), ' favourite fetched successfully');
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
    public function store(Request $request, $id)
    {
        $user = auth()->user();
        if ($user->role)
            return $this->apiResponse(null, 'access only for pharmacist');


        $medicine = Medicine::find($id);
        if (!$medicine) {
            return $this->apiResponse(null, 'No medicine found with the specified ID');
        }
//        if ($user->favoriteMedicines()->where('medicine_id', $medicine->id)->exists()) {
//            return $this->apiResponse(null, 'This medicine is already in favorites');
//
//        }
        $favoriteMedicine = FavoritMedicine::where('user_id', $user->id)
            ->where('medicine_id', $id)->first();

        if (!$favoriteMedicine) {

            FavoritMedicine::create([
                'user_id' => $user->id,
                'medicine_id' => $medicine->id,
            ]);

            return $this->apiResponse(null, 'Medicine add to the favourite successfully');
        }
        else
        {

            return $this->apiResponse(null, 'Medicine already in favourite ');
        }
        }
            /**
     * Display the specified resource.
     */
    public function show(FavoritMedicine $favoritMedicine)
    {
        $user = auth()->user();
        if ($user->role)
            return $this->apiResponse(null, 'access only for pharmacist');

        $medicines = FavoritMedicine::where('user_id', $user->id)->with('medicine')->get();

        return $this->apiResponse($medicines, 'my favourite');
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
    public function destroy($id)
    {
        $user = auth()->user();
        if ($user->role)
            return $this->apiResponse(null, 'access only for pharmacist');


        $medicine = Medicine::find($id);

        if (!$medicine) {
            return $this->apiResponse($medicine, 'the medicine not found');
        }
        $favoriteMedicine = FavoritMedicine::where('user_id', $user->id)
            ->where('medicine_id', $id)->first();

        if ($favoriteMedicine) {
        $result = $favoriteMedicine->delete();
        if ($result) {
            return $this->apiResponse(null, 'the medicine deleted from favourite');
        }
    }
}
}
