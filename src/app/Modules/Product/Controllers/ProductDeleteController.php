<?php

namespace App\Modules\Product\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Product\Services\ProductService;

class ProductDeleteController extends Controller
{
    private $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function get($id){
        $product = $this->productService->getById($id);

        try {
            //code...
            $this->productService->delete(
                $product
            );
            return redirect()->back()->with('success_status', 'Product deleted successfully.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error_status', 'Something went wrong. Please try again');
        }
    }

}