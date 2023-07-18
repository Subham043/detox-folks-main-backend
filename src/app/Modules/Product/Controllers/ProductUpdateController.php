<?php

namespace App\Modules\Product\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Category\Services\CategoryService;
use App\Modules\Product\Requests\ProductUpdateRequest;
use App\Modules\Product\Services\ProductService;
use App\Modules\SubCategory\Services\SubCategoryService;

class ProductUpdateController extends Controller
{
    private $productService;
    private $categoryService;
    private $subcategoryService;

    public function __construct(ProductService $productService, CategoryService $categoryService, SubCategoryService $subcategoryService)
    {
        $this->middleware('permission:edit products', ['only' => ['get','post']]);
        $this->productService = $productService;
        $this->categoryService = $categoryService;
        $this->subcategoryService = $subcategoryService;
    }

    public function get($id){
        $data = $this->productService->getById($id);
        $category = $this->categoryService->all();
        $categories =$data->categories->pluck('id')->toArray();
        $sub_categories =$data->sub_categories->pluck('id')->toArray();
        $sub_category = $this->subcategoryService->get_subcategories($categories);
        return view('admin.pages.product.update', compact(['data', 'category', 'categories', 'sub_category', 'sub_categories']));
    }

    public function post(ProductUpdateRequest $request, $id){
        $product = $this->productService->getById($id);
        try {
            //code...
            $this->productService->update(
                $request->except(['image']),
                $product
            );
            if($request->hasFile('image')){
                $this->productService->saveImage($product);
            }
            if($request->category && count($request->category)>0){
                $this->productService->save_categories($product, $request->category);
            }
            if($request->sub_category && count($request->sub_category)>0){
                $this->productService->save_sub_categories($product, $request->sub_category);
            }else{
                $this->productService->save_sub_categories($product, []);
            }
            return response()->json(["message" => "Product updated successfully."], 201);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Something went wrong. Please try again"], 400);
        }

    }
}
