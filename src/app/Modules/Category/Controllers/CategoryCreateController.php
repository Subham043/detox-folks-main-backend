<?php

namespace App\Modules\Category\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Category\Requests\CategoryCreateRequest;
use App\Modules\Category\Services\CategoryService;

class CategoryCreateController extends Controller
{
    private $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->middleware('permission:create categories', ['only' => ['get','post']]);
        $this->categoryService = $categoryService;
    }

    public function get(){
        return view('admin.pages.category.create');
    }

    public function post(CategoryCreateRequest $request){

        try {
            //code...
            $category = $this->categoryService->create(
                $request->except(['image'])
            );
            if($request->hasFile('image')){
                $this->categoryService->saveImage($category);
            }
            return response()->json(["message" => "Category created successfully."], 201);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Something went wrong. Please try again"], 400);
        }

    }
}
