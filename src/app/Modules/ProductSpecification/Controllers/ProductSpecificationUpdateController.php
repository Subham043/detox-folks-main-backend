<?php

namespace App\Modules\ProductSpecification\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\ProductSpecification\Requests\ProductSpecificationRequest;
use App\Modules\ProductSpecification\Services\ProductSpecificationService;

class ProductSpecificationUpdateController extends Controller
{
    private $productSpecificationService;

    public function __construct(ProductSpecificationService $productSpecificationService)
    {
        $this->middleware('permission:edit products', ['only' => ['get','post']]);
        $this->productSpecificationService = $productSpecificationService;
    }

    public function get($product_id, $id){
        $data = $this->productSpecificationService->getByProductIdAndId($product_id, $id);
        return view('admin.pages.product_specification.update', compact(['data', 'product_id']));
    }

    public function post(ProductSpecificationRequest $request, $product_id, $id){
        $product = $this->productSpecificationService->getByProductIdAndId($product_id, $id);
        try {
            //code...
            $this->productSpecificationService->update(
                $request->validated(),
                $product
            );
            return response()->json(["message" => "Product Specification updated successfully."], 201);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Something went wrong. Please try again"], 400);
        }

    }
}
