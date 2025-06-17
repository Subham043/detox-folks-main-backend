<?php

namespace App\Modules\ProductVideo\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Product\Services\ProductService;
use App\Modules\ProductVideo\Requests\ProductVideoCreateRequest;
use App\Modules\ProductVideo\Services\ProductVideoService;

class ProductVideoCreateController extends Controller
{
    private $productVideoService;
    private $productService;

    public function __construct(ProductVideoService $productVideoService, ProductService $productService)
    {
        $this->productVideoService = $productVideoService;
        $this->productService = $productService;
    }

    public function get($product_id){
        $this->productService->getById($product_id);
        return view('admin.pages.product_video.create', compact(['product_id']));
    }

    public function post(ProductVideoCreateRequest $request, $product_id){

        try {
            //code...
            $this->productVideoService->create(
                [
                    ...$request->validated(),
                    'product_id' => $product_id
                ]
            );
            return response()->json(["message" => "Product Video created successfully."], 201);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Something went wrong. Please try again"], 400);
        }

    }
}
