<?php

namespace App\Modules\ProductPrice\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Product\Services\ProductService;
use App\Modules\ProductPrice\Requests\ProductPriceRequest;
use App\Modules\ProductPrice\Services\ProductPriceService;

class ProductPriceCreateController extends Controller
{
    private $productPriceService;
    private $productService;

    public function __construct(ProductPriceService $productPriceService, ProductService $productService)
    {
        $this->middleware('permission:create products', ['only' => ['get','post']]);
        $this->productPriceService = $productPriceService;
        $this->productService = $productService;
    }

    public function get($product_id){
        $this->productService->getById($product_id);
        return view('admin.pages.product_price.create', compact(['product_id']));
    }

    public function post(ProductPriceRequest $request, $product_id){

        try {
            //code...
            $productPrice = $this->productPriceService->create(
                [
                    ...$request->validated(),
                    'product_id' => $product_id
                ]
            );
            return response()->json(["message" => "Product Price created successfully."], 201);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Something went wrong. Please try again"], 400);
        }

    }
}
