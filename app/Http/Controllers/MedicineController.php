<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Medicine;
use App\Http\Requests\StoreMedicineRequest;
use App\Http\Requests\UpdateMedicineRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MedicineController extends Controller

{
    use Apitrait;

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
        $validator = Validator::make($request->all(), [
            'commercial_name' => 'required',
            'scientific_name' => 'required',
            'manufacture_company' => 'required',
            'price' => 'required'

        ]);
        if ($validator->fails()) {
            return $this->apiResponse(null, $validator->errors(), 400);
        }
        $medicine = Medicine::create($request->all());

        if ($medicine) {
            return $this->apiResponse($medicine, 'the medicine inserted', 201);
        }

        return $this->apiResponse(null, 'the medicine didn\'t created', 401);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Medicine::find($id);

    }

    public function show_category ($category_id)
    {
        $medicine=Medicine::Where('category_id',$category_id)->get()->except(Category::class);
        if ($medicine) {
            return $this->apiResponse($medicine, 'the medicine inserted' );
        }

        return $this->apiResponse(null, 'the medicine didn\'t created');
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

    public function update(Request $request, $medicine_id)
    {
        $validator = Validator::make($request->all(), [
            'scientific_name' => 'required|string|max:25',
            'category_id' => 'required',
            'trade_name' => 'required|string|max:25',
            'company' => 'required|string|max:25',
            'price' => 'required|max:25'
        ]);
        if ($validator->fails()) {
            return $this->apiResponse(null, $validator->errors(), 400);
        }
        $medicine = Medicine::find($medicine_id);
        if (!$medicine) {
            return $this->apiResponse($medicine, 'the post not found', 404);
        }
        $medicine->update($request->all());
        if ($medicine) {
            return $this->apiResponse($medicine, 'the post updated', 201);
        }

    }

    /**
     * Remove the specified resource from storage.
     */

    public function destroy($id)
    {
        $medicine = Medicine::find($id);
        if (!$medicine) {
            return $this->apiResponse($medicine, 'the medicine not found', 404);
        }
        $medicine->delete($id);
        if ($medicine) {
            return $this->apiResponse(null, 'the medicine deleted', 200);
        }
    }

    public function search($name)

    {
        $medicine = Medicine::Where('commercial_name', 'like', '%' . $name . '%')
            ->orwhere('scientific_name', 'like', '%' . $name . '%')
            ->get();
        if ($medicine) {
            return $this->apiResponse($medicine, 'here ur search', 200);
        }

    }
}
