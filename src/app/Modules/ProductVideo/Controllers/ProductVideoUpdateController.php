<?php

namespace App\Modules\ProductVideo\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\ProductVideo\Requests\ProductVideoUpdateRequest;
use App\Modules\ProductVideo\Services\ProductVideoService;

class ProductVideoUpdateController extends Controller
{
    private $productVideoService;

    public function __construct(ProductVideoService $productVideoService)
    {
        $this->productVideoService = $productVideoService;
    }

    public function get($product_id, $id){
        $data = $this->productVideoService->getByProductIdAndId($product_id, $id);
        return view('admin.pages.product_video.update', compact(['data', 'product_id']));
    }

    public function post(ProductVideoUpdateRequest $request, $product_id, $id){
        $productVideo = $this->productVideoService->getByProductIdAndId($product_id, $id);
        try {
            //code...
            $this->productVideoService->update(
                $request->validated(),
                $productVideo
            );
            return response()->json(["message" => "Product Video updated successfully."], 201);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Something went wrong. Please try again"], 400);
        }

    }
}
