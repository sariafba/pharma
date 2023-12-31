<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Medicine;
use App\Http\Requests\StoreMedicineRequest;
use App\Http\Requests\UpdateMedicineRequest;
use App\Models\StatusMedicine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Psy\Util\Str;
use Ramsey\Uuid\Type\Integer;
use Illuminate\Support\Facades\URL;

class MedicineController extends Controller

{
    use Apitrait;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->apiResponse(Medicine::all(), 'medicine fetched successfully');
    }




    public function store(Request $request)
    {

        //access just for admin
        if(!auth()->user()->role)
            return $this->apiResponse(null, 'access only for admin');

        $validatedData = $request->validate([
            'commercial_name' => 'required|string|unique:medicines,commercial_name',
            'scientific_name' => 'required|string',
            'manufacture_company' => 'required|string',
            'price' => 'required|integer',
           'image'=>'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'category_id' => 'required|integer|exists:categories,id',
            'quantity' => 'required|integer',
            'expiration_date' => 'required|date_format:Y-m-d'
        ]);



            $imageName = time() . '_' . uniqid() . '.' . $request->image->extension();
            $path = $request->image->storeAs('photo/', $imageName, 'public');
           $imageUrl = URL::asset('storage/photo/' . $imageName);

        $medicine = Medicine::create([
            'commercial_name' => $validatedData['commercial_name'],
            'scientific_name' => $validatedData['scientific_name'],
            'manufacture_company' => $validatedData['manufacture_company'],
            'quantity' => $validatedData['quantity'],
            'price' => $validatedData['price'],
            'image'=>$imageUrl,
            'category_id' => $validatedData['category_id']
        ]);

        StatusMedicine::create([
            'medicine_id' => $medicine->id,
            'quantity' => $validatedData['quantity'],
            'expiration_date' => $validatedData['expiration_date']
        ]);
          $data=[
            'medicine'=>$medicine,
      //  'imageUrl'=>$imageUrl
            ];
        return $this->apiResponse($data,'medicine stored successfully');
    }



    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //show for pharmacist
        if(!auth()->user()->role)
            return $this->apiResponse(Medicine::find($id), 'medicine fetched successfully');
        //show for admin
        else
            return $this->apiResponse(Medicine::with('statusMedicines')
                ->find($id),'medicine fetched successfully');
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, $id)
    {
        //access just for admin
        if(!auth()->user()->role)
            return $this->apiResponse(null, 'access only for admin');

        $medicine = Medicine::find($id);

        if (!$medicine)
            return $this->apiResponse(null, 'No medicine found with the specified ID');

        $request->validate([
            //لانو وانت عم تعدل اسم الدوا اذا حطيت اسم موجود يضربلك ايرور
            // واذا نفس اسم الدوا يلي عم تعدل عليه مايحاكيك شي "ترجمها انت بكرا بالله :)"
            'commercial_name' => 'string|unique:medicines,commercial_name,' . $medicine->id,
            'scientific_name' => 'string',
            'manufacture_company' => 'string',
            'category_id' => 'integer|exists:categories,id',
            'price' => 'integer',
//            'image'=>'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('image'))
        {
            $imageName = time() . '_' . uniqid() . '.' . $request->image->extension();
            $path = $request->image->storeAs('photo/', $imageName, 'public');
            $imageUrl = URL::asset('storage/photo/' . $imageName);
        }
        $medicine->update([
            //can use put, it's a security mistake
            //$request->all()
            //so use these approach instead
            'commercial_name' => $request->input('commercial_name') ?? $medicine->commercial_name,
            'scientific_name' => $request->input('scientific_name') ?? $medicine->scientific_name,
            'manufacture_company' => $request->input('manufacture_company') ?? $medicine->manufacture_company,
            'price' => $request->input('price') ?? $medicine->price,
            'image'=> $imageUrl ?? null,
            'category_id' => $request->input('category_id') ?? $medicine->category_id
        ]) ;


        return $this->apiResponse($medicine, 'the medicine updated');


    }

    /**
     * Remove the specified resource from storage.
     */

    public function destroy($id)
    {
        //access just for admin
        if(!auth()->user()->role)
            return $this->apiResponse(null, 'access only for admin');

        $medicine = Medicine::find($id);

        if (!$medicine) {
            return $this->apiResponse($medicine, 'the medicine not found');
        }

        $result = $medicine->delete($id);

        if ($result) {
            return $this->apiResponse(null, 'the medicine deleted');
        }

    }

    /**
     * search for medicine by name
     */

    public function search($name)
    {
        $medicine = Medicine::where('commercial_name', 'like', '%' . $name . '%')
            ->orwhere('scientific_name', 'like', '%' . $name . '%')
            ->get();
        if ($medicine) {
            return $this->apiResponse($medicine, 'here ur search');
        }

    }
}
