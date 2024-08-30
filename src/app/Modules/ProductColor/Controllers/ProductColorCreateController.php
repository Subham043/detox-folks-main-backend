<?php

namespace App\Modules\ProductColor\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Product\Services\ProductService;
use App\Modules\ProductColor\Requests\ProductColorRequest;
use App\Modules\ProductColor\Services\ProductColorService;

class ProductColorCreateController extends Controller
{
    private $productColorService;
    private $productService;

    public function __construct(ProductColorService $productColorService, ProductService $productService)
    {
        $this->productColorService = $productColorService;
        $this->productService = $productService;
    }

    public function get($product_id){
        $this->productService->getById($product_id);
        return view('admin.pages.product_color.create', compact(['product_id']));
    }

    public function post(ProductColorRequest $request, $product_id){

        try {
            //code...
            $productColor = $this->productColorService->create(
                [
                    ...$request->validated(),
                    'product_id' => $product_id
                ]
            );
            return response()->json(["message" => "Product Color created successfully."], 201);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Something went wrong. Please try again"], 400);
        }

    }
}
