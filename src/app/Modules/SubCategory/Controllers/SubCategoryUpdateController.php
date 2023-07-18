<?php

namespace App\Modules\SubCategory\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Category\Services\CategoryService;
use App\Modules\SubCategory\Requests\SubCategoryUpdateRequest;
use App\Modules\SubCategory\Services\SubCategoryService;

class SubCategoryUpdateController extends Controller
{
    private $subcategoryService;
    private $categoryService;

    public function __construct(SubCategoryService $subcategoryService, CategoryService $categoryService)
    {
        $this->middleware('permission:edit categories', ['only' => ['get','post']]);
        $this->subcategoryService = $subcategoryService;
        $this->categoryService = $categoryService;
    }

    public function get($id){
        $data = $this->subcategoryService->getById($id);
        $category = $this->categoryService->all();
        $categories =$data->categories->pluck('id')->toArray();
        return view('admin.pages.sub_category.update', compact(['data', 'category', 'categories']));
    }

    public function post(SubCategoryUpdateRequest $request, $id){
        $subcategory = $this->subcategoryService->getById($id);
        try {
            //code...
            $this->subcategoryService->update(
                $request->except(['image']),
                $subcategory
            );
            if($request->hasFile('image')){
                $this->subcategoryService->saveImage($subcategory);
            }
            if($request->category && count($request->category)>0){
                $this->subcategoryService->save_categories($subcategory, $request->category);
            }
            return response()->json(["message" => "SubCategory updated successfully."], 201);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Something went wrong. Please try again"], 400);
        }

    }
}
