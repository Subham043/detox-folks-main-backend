<?php

namespace App\Modules\Product\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Category\Services\CategoryService;
use App\Modules\Product\Requests\ProductUpdateRequest;
use App\Modules\Product\Services\ProductService;
use App\Modules\SubCategory\Services\SubCategoryService;
use App\Modules\Tax\Services\TaxService;
use Illuminate\Support\Facades\DB;

class ProductUpdateController extends Controller
{
    private $productService;
    private $categoryService;
    private $subcategoryService;
    private $taxService;

    public function __construct(ProductService $productService, CategoryService $categoryService, SubCategoryService $subcategoryService, TaxService $taxService)
    {
        $this->productService = $productService;
        $this->categoryService = $categoryService;
        $this->subcategoryService = $subcategoryService;
        $this->taxService = $taxService;
    }

    public function get($id){
        $data = $this->productService->getById($id);
        $category = $this->categoryService->all();
        $categories =$data->categories->pluck('id')->toArray();
        $sub_categories =$data->sub_categories->pluck('id')->toArray();
        $sub_category = $this->subcategoryService->get_subcategories($categories);
        $tax = $this->taxService->all();
        $taxes =$data->taxes->pluck('id')->toArray();
        return view('admin.pages.product.update', compact(['data', 'category', 'categories', 'sub_category', 'sub_categories', 'tax', 'taxes']));
    }

    public function post(ProductUpdateRequest $request, $id){
        // return response()->json(["message" => "Something went wrong. Please try again", "test" => $request->specifications], 400);
        $product = $this->productService->getById($id);
        DB::beginTransaction();
        try {
            //code...
            $this->productService->update(
                $request->except(['image', 'specifications', 'prices', 'tax', 'category', 'sub_category']),
                $product
            );
            if($request->hasFile('image')){
                $this->productService->saveImage($product);
            }
            if($request->tax && count($request->tax)>0){
                $this->productService->save_taxes($product, $request->tax);
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
                $this->productService->save_specifications($product, $request->specifications);
            }
            if($request->prices && count($request->prices)>0){
                $this->productService->save_prices($product, $request->prices);
            }
            return response()->json(["message" => "Product updated successfully."], 201);
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
            return response()->json(["message" => "Something went wrong. Please try again"], 400);
        } finally {
            DB::commit();
        }

    }
}
