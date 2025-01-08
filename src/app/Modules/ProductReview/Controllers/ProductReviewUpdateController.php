<?php

namespace App\Modules\ProductReview\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\ProductReview\Requests\ProductReviewRequest;
use App\Modules\ProductReview\Services\ProductReviewService;

class ProductReviewUpdateController extends Controller
{
    private $productReviewService;

    public function __construct(ProductReviewService $productReviewService)
    {
        $this->productReviewService = $productReviewService;
    }

    public function get($product_id, $id){
        $data = $this->productReviewService->getByProductIdAndId($product_id, $id);
        return view('admin.pages.product_review.update', compact(['data', 'product_id']));
    }

    public function post(ProductReviewRequest $request, $product_id, $id){
        $productReview = $this->productReviewService->getByProductIdAndId($product_id, $id);
        try {
            //code...
            $this->productReviewService->update(
                $request->validated(),
                $productReview
            );
            return response()->json(["message" => "Product Review updated successfully."], 201);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Something went wrong. Please try again"], 400);
        }

    }
}
