<?php

namespace App\Modules\Product\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Product\Resources\UserProductCollection;
use App\Modules\Product\Services\ProductService;

class UserProductDetailController extends Controller
{
    private $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function get($slug){
        $data = $this->productService->getBySlug($slug);
        return response()->json([
            'message' => "Category recieved successfully.",
            'product' => UserProductCollection::make($data),
        ], 200);
    }
}
