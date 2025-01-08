<?php

namespace App\Modules\ProductReview\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Product\Services\ProductService;
use App\Modules\ProductReview\Requests\ProductReviewRequest;
use App\Modules\ProductReview\Resources\UserProductReviewCollection;
use App\Modules\ProductReview\Services\ProductReviewService;

class UserProductReviewCreateController extends Controller
{
    private $productReviewService;
    private $productService;

    public function __construct(ProductReviewService $productReviewService, ProductService $productService)
    {
        $this->productReviewService = $productReviewService;
        $this->productService = $productService;
    }

    public function post(ProductReviewRequest $request, $product_slug){

        $product = $this->productService->getBySlug($product_slug);

        try {
            //code...
            $productReview = $this->productReviewService->create(
                [
                    ...$request->validated(),
                    'product_id' => $product->id
                ]
            );
            return response()->json([
                "message" => "Product Review created successfully.",
                'review' => UserProductReviewCollection::make($productReview),
            ], 201);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Something went wrong. Please try again"], 400);
        }

    }
}
