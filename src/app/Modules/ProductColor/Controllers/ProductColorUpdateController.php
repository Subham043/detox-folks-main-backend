<?php

namespace App\Modules\ProductColor\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\ProductColor\Requests\ProductColorRequest;
use App\Modules\ProductColor\Services\ProductColorService;

class ProductColorUpdateController extends Controller
{
    private $productColorService;

    public function __construct(ProductColorService $productColorService)
    {
        $this->productColorService = $productColorService;
    }

    public function get($product_id, $id){
        $data = $this->productColorService->getByProductIdAndId($product_id, $id);
        return view('admin.pages.product_color.update', compact(['data', 'product_id']));
    }

    public function post(ProductColorRequest $request, $product_id, $id){
        $productColor = $this->productColorService->getByProductIdAndId($product_id, $id);
        try {
            //code...
            $this->productColorService->update(
                $request->validated(),
                $productColor
            );
            return response()->json(["message" => "Product Color updated successfully."], 201);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Something went wrong. Please try again"], 400);
        }

    }
}
