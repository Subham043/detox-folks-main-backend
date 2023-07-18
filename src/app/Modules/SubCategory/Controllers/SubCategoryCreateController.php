<?php

namespace App\Modules\SubCategory\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Category\Services\CategoryService;
use App\Modules\SubCategory\Requests\SubCategoryCreateRequest;
use App\Modules\SubCategory\Services\SubCategoryService;

class SubCategoryCreateController extends Controller
{
    private $subcategoryService;
    private $categoryService;

    public function __construct(SubCategoryService $subcategoryService, CategoryService $categoryService)
    {
        $this->middleware('permission:create categories', ['only' => ['get','post']]);
        $this->subcategoryService = $subcategoryService;
        $this->categoryService = $categoryService;
    }

    public function get(){
        $category = $this->categoryService->all();
        return view('admin.pages.sub_category.create', compact(['category']));
    }

    public function post(SubCategoryCreateRequest $request){

        try {
            //code...
            $subcategory = $this->subcategoryService->create(
                $request->except(['image'])
            );
            if($request->hasFile('image')){
                $this->subcategoryService->saveImage($subcategory);
            }
            if($request->category && count($request->category)>0){
                $this->subcategoryService->save_categories($subcategory, $request->category);
            }
            return response()->json(["message" => "SubCategory created successfully."], 201);
        } catch (\Throwable $th) {
            throw $th;
            return response()->json(["message" => "Something went wrong. Please try again"], 400);
        }

    }
}
