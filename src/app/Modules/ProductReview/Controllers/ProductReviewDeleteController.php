<?php

namespace App\Modules\ProductReview\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\ProductReview\Services\ProductReviewService;

class ProductReviewDeleteController extends Controller
{
    private $productReviewService;

    public function __construct(ProductReviewService $productReviewService)
    {
        $this->productReviewService = $productReviewService;
    }

    public function get($product_id, $id){
        $productReview = $this->productReviewService->getByProductIdAndId($product_id, $id);

        try {
            //code...
            $this->productReviewService->delete(
                $productReview
            );
            return redirect()->back()->with('success_status', 'Product Review deleted successfully.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error_status', 'Something went wrong. Please try again');
        }
    }

}
