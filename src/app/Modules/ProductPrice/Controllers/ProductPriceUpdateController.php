<?php

namespace App\Modules\ProductPrice\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\ProductPrice\Requests\ProductPriceRequest;
use App\Modules\ProductPrice\Services\ProductPriceService;

class ProductPriceUpdateController extends Controller
{
    private $productPriceService;

    public function __construct(ProductPriceService $productPriceService)
    {
        $this->middleware('permission:edit products', ['only' => ['get','post']]);
        $this->productPriceService = $productPriceService;
    }

    public function get($product_id, $id){
        $data = $this->productPriceService->getByProductIdAndId($product_id, $id);
        return view('admin.pages.product_price.update', compact(['data', 'product_id']));
    }

    public function post(ProductPriceRequest $request, $product_id, $id){
        $productPrice = $this->productPriceService->getByProductIdAndId($product_id, $id);
        try {
            //code...
            $this->productPriceService->update(
                $request->validated(),
                $productPrice
            );
            return response()->json(["message" => "Product Price updated successfully."], 201);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Something went wrong. Please try again"], 400);
        }

    }
}
