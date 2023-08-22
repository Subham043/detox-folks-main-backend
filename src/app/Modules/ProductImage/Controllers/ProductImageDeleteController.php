<?php

namespace App\Modules\ProductImage\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\ProductImage\Services\ProductImageService;

class ProductImageDeleteController extends Controller
{
    private $productImageService;

    public function __construct(ProductImageService $productImageService)
    {
        $this->middleware('permission:delete products', ['only' => ['get']]);
        $this->productImageService = $productImageService;
    }

    public function get($product_id, $id){
        $productImage = $this->productImageService->getByProductIdAndId($product_id, $id);

        try {
            //code...
            $this->productImageService->delete(
                $productImage
            );
            return redirect()->back()->with('success_status', 'Product Image deleted successfully.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error_status', 'Something went wrong. Please try again');
        }
    }

}
