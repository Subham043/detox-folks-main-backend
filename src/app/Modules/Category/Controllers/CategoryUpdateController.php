<?php

namespace App\Modules\Category\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Category\Requests\CategoryUpdateRequest;
use App\Modules\Category\Services\CategoryService;

class CategoryUpdateController extends Controller
{
    private $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function get($id){
        $data = $this->categoryService->getById($id);
        return view('admin.pages.category.update', compact(['data']));
    }

    public function post(CategoryUpdateRequest $request, $id){
        $category = $this->categoryService->getById($id);
        try {
            //code...
            $this->categoryService->update(
                $request->except(['image']),
                $category
            );
            if($request->hasFile('image')){
                $this->categoryService->saveImage($category);
            }
            return response()->json(["message" => "Category updated successfully."], 201);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Something went wrong. Please try again"], 400);
        }

    }
}