<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Medicine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    use Apitrait;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->apiResponse(Category::all(),'categories fetched successfully');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //access just for admin
        if(!auth()->user()->role)
            return $this->apiResponse(null, 'access only for admin');

        $request->validate([
            'name'=>'required|unique:categories,name'
        ]);

        $category= Category::create([

            'name' => $request->input('name')
        ]);

        if ($category){
            return $this->apiResponse($category,'new category created');
        }

        return $this->apiResponse(null,'not created');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {

        $category = Category::with('medicines')->find($id);

        if (!$category) {
            return $this->apiResponse(null, 'Category not found.');
        }

        $medicines = $category->medicines;
        $categoryName = $category->name;

        $data = [
            'category' => $categoryName,
            'medicines' => $medicines,
        ];

        return $this->apiResponse($data, 'Medicines for the given category.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {

        //access just for admin
        if(!auth()->user()->role)
            return $this->apiResponse(null, 'access only for admin');

        $category = Category::find($id);

        if (!$category) {
            return $this->apiResponse($category, 'No category found with the specified ID' );
        }

        $request->validate([
            'name' => 'required|string|unique:categories,name,' . $category->id
        ]);

        $category->update([
            'name' => $request->input('name')
        ]);

        if ($category) {
            return $this->apiResponse($category, 'category name updated' );
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //access just for admin
        if(!auth()->user()->role)
            return $this->apiResponse(null, 'access only for admin');

        $category = Category::find($id);

        if (!$category)
            return $this->apiResponse(null, 'the category not found');

        $result = $category->delete($id);

        if ($result){
            return $this->apiResponse(null, 'the category deleted and all medicines related');
        }
    }
}
