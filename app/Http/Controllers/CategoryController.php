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
        return Category::all();
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
     $request->validate([  'name'=>'required|unique']);

       $category= Category::create($request->only('name'));

        if ($category){
            return $this->apiResponse($category,'created');
        }

        return $this->apiResponse(null,'not created');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {


    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {

    }
    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, String $category_id)
    {
         $request->validate([ 'name' => 'required']);

        $category = Category::find($category_id);

        if (!$category) {
            return $this->apiResponse($category, 'the post not found' );
        }

        $category->update($request->only('name'));

        if ($category) {
            return $this->apiResponse($category, 'the post updated' );
        }
    }
        /**
     * Remove the specified resource from storage.
     */

        public function destroy($id)
    {
        $category = Category::find($id);

        if (!$category) {
            return $this->apiResponse($category, 'the category not found', 404);
        }
        $category->delete($id);
        if ($category){
            return $this->apiResponse(null, 'the category deleted', 200);
        }
    }
}
