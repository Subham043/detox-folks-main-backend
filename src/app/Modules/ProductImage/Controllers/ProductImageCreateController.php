<?php

namespace App\Modules\ProductImage\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Product\Services\ProductService;
use App\Modules\ProductImage\Requests\ProductImageCreateRequest;
use App\Modules\ProductImage\Services\ProductImageService;

class ProductImageCreateController extends Controller
{
    private $productImageService;
    private $productService;

    public function __construct(ProductImageService $productImageService, ProductService $productService)
    {
        $this->productImageService = $productImageService;
        $this->productService = $productService;
    }

    public function get($product_id){
        $this->productService->getById($product_id);
        return view('admin.pages.product_image.create', compact(['product_id']));
    }

    public function post(ProductImageCreateRequest $request, $product_id){

        try {
            //code...
            $productImage = $this->productImageService->create(
                [
                    ...$request->except(['image']),
                    'product_id' => $product_id
                ]
            );
            if($request->hasFile('image')){
                $this->productImageService->saveImage($productImage);
            }
            return response()->json(["message" => "Product Image created successfully."], 201);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Something went wrong. Please try again"], 400);
        }

    }
}