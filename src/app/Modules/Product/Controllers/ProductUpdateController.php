<?php

namespace App\Modules\Product\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Category\Services\CategoryService;
use App\Modules\Product\Requests\ProductUpdateRequest;
use App\Modules\Product\Services\ProductService;

class ProductUpdateController extends Controller
{
    private $productService;
    private $categoryService;

    public function __construct(ProductService $productService, CategoryService $categoryService)
    {
        $this->middleware('permission:edit products', ['only' => ['get','post']]);
        $this->productService = $productService;
        $this->categoryService = $categoryService;
    }

    public function get($id){
        $data = $this->productService->getById($id);
        $category = $this->categoryService->all();
        $categories =$data->categories->pluck('id')->toArray();
        return view('admin.pages.product.update', compact(['data', 'category', 'categories']));
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
            return response()->json(["message" => "Product updated successfully."], 201);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Something went wrong. Please try again"], 400);
        }

    }
}
