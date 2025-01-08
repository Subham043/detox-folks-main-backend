<?php

namespace App\Modules\ProductReview\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Product\Services\ProductService;
use App\Modules\ProductReview\Resources\UserProductReviewCollection;
use App\Modules\ProductReview\Services\ProductReviewService;
use Illuminate\Http\Request;

class UserProductReviewPaginateController extends Controller
{
    private $productReviewService;
    private $productService;

    public function __construct(ProductReviewService $productReviewService, ProductService $productService)
    {
        $this->productReviewService = $productReviewService;
        $this->productService = $productService;
    }

    public function get(Request $request, $product_slug){
        $product = $this->productService->getBySlug($product_slug);
        $data = $this->productReviewService->paginateMain($request->total ?? 10, $product->id);
        return UserProductReviewCollection::collection($data);
    }

}
