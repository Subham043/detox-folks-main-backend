<?php

namespace App\Modules\Category\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Category\Requests\CategoryApiRequest;
use App\Modules\SubCategory\Services\SubCategoryService;

class CategoryApiController extends Controller
{
    private $subcategoryService;

    public function __construct(SubCategoryService $subcategoryService)
    {
        $this->middleware('permission:create products', ['only' => ['post']]);
        $this->subcategoryService = $subcategoryService;
    }


    public function post(CategoryApiRequest $request){

        try {
            if($request->category && count($request->category)>0){
                $data = $this->subcategoryService->get_subcategories($request->category);
                return response()->json(["message" => "Category created successfully.", "sub_categories"=>$data], 200);
            }
            return response()->json(["message" => "Category created successfully.", "sub_categories"=>[]], 200);
        } catch (\Throwable $th) {
            throw $th;
            return response()->json(["message" => "Something went wrong. Please try again"], 400);
        }

    }
}
