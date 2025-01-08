<?php

namespace App\Modules\ProductReview\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Product\Services\ProductService;
use App\Modules\ProductReview\Requests\ProductReviewRequest;
use App\Modules\ProductReview\Services\ProductReviewService;

class ProductReviewCreateController extends Controller
{
    private $productReviewService;
    private $productService;

    public function __construct(ProductReviewService $productReviewService, ProductService $productService)
    {
        $this->productReviewService = $productReviewService;
        $this->productService = $productService;
    }

    public function get($product_id){
        $this->productService->getById($product_id);
        return view('admin.pages.product_review.create', compact(['product_id']));
    }

    public function post(ProductReviewRequest $request, $product_id){

        try {
            //code...
            $productReview = $this->productReviewService->create(
                [
                    ...$request->validated(),
                    'product_id' => $product_id,
                    'user_id' => auth()->user()->id
                ]
            );
            return response()->json(["message" => "Product Review created successfully."], 201);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Something went wrong. Please try again"], 400);
        }

    }
}
