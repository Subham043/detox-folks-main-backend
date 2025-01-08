<?php

namespace App\Modules\ProductReview\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\ProductReview\Services\ProductReviewService;
use Illuminate\Http\Request;

class ProductReviewPaginateController extends Controller
{
    private $productReviewService;

    public function __construct(ProductReviewService $productReviewService)
    {
        $this->productReviewService = $productReviewService;
    }

    public function get(Request $request, $product_id){
        $data = $this->productReviewService->paginate($request->total ?? 10, $product_id);
        return view('admin.pages.product_review.paginate', compact(['data', 'product_id']))
            ->with('search', $request->query('filter')['search'] ?? '');
    }

}
