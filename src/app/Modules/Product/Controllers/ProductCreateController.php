<?php

namespace App\Modules\Product\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Category\Services\CategoryService;
use App\Modules\Product\Requests\ProductCreateRequest;
use App\Modules\Product\Services\ProductService;
use Illuminate\Support\Facades\DB;

class ProductCreateController extends Controller
{
    private $productService;
    private $categoryService;

    public function __construct(ProductService $productService, CategoryService $categoryService)
    {
        $this->productService = $productService;
        $this->categoryService = $categoryService;
    }

    public function get(){
        $category = $this->categoryService->all();
        return view('admin.pages.product.create', compact(['category']));
    }

    public function post(ProductCreateRequest $request){
        DB::beginTransaction();
        try {
            //code...
            $product = $this->productService->create(
                $request->except(['image', 'specifications', 'prices'])
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
            if($request->specifications && count($request->specifications)>0){
                $this->productService->create_specifications($product, $request->specifications);
            }
            if($request->prices && count($request->prices)>0){
                $this->productService->create_prices($product, $request->prices);
            }
            return response()->json(["message" => "Product created successfully."], 201);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(["message" => "Something went wrong. Please try again"], 400);
        } finally {
            DB::commit();
        }

    }
}