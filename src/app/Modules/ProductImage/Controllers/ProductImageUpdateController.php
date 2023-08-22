<?php

namespace App\Modules\ProductImage\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\ProductImage\Requests\ProductImageUpdateRequest;
use App\Modules\ProductImage\Services\ProductImageService;

class ProductImageUpdateController extends Controller
{
    private $productImageService;

    public function __construct(ProductImageService $productImageService)
    {
        $this->middleware('permission:edit products', ['only' => ['get','post']]);
        $this->productImageService = $productImageService;
    }

    public function get($product_id, $id){
        $data = $this->productImageService->getByProductIdAndId($product_id, $id);
        return view('admin.pages.product_image.update', compact(['data', 'product_id']));
    }

    public function post(ProductImageUpdateRequest $request, $product_id, $id){
        $productImage = $this->productImageService->getByProductIdAndId($product_id, $id);
        try {
            //code...
            $this->productImageService->update(
                $request->except(['image']),
                $productImage
            );
            if($request->hasFile('image')){
                $this->productImageService->saveImage($productImage);
            }
            return response()->json(["message" => "Product Image updated successfully."], 201);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Something went wrong. Please try again"], 400);
        }

    }
}
