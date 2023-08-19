<?php

namespace App\Modules\ProductSpecification\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Product\Services\ProductService;
use App\Modules\ProductSpecification\Requests\ProductSpecificationRequest;
use App\Modules\ProductSpecification\Services\ProductSpecificationService;

class ProductSpecificationCreateController extends Controller
{
    private $productSpecificationService;
    private $productService;

    public function __construct(ProductSpecificationService $productSpecificationService, ProductService $productService)
    {
        $this->middleware('permission:create products', ['only' => ['get','post']]);
        $this->productSpecificationService = $productSpecificationService;
        $this->productService = $productService;
    }

    public function get($product_id){
        $this->productService->getById($product_id);
        return view('admin.pages.product_specification.create', compact(['product_id']));
    }

    public function post(ProductSpecificationRequest $request, $product_id){

        try {
            //code...
            $productSpecification = $this->productSpecificationService->create(
                [
                    ...$request->validated(),
                    'product_id' => $product_id
                ]
            );
            return response()->json(["message" => "Product Specification created successfully."], 201);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Something went wrong. Please try again"], 400);
        }

    }
}
