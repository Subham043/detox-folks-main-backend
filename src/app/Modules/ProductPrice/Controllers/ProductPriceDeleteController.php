<?php

namespace App\Modules\ProductPrice\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\ProductPrice\Services\ProductPriceService;

class ProductPriceDeleteController extends Controller
{
    private $productPriceService;

    public function __construct(ProductPriceService $productPriceService)
    {
        $this->productPriceService = $productPriceService;
    }

    public function get($product_id, $id){
        $productPrice = $this->productPriceService->getByProductIdAndId($product_id, $id);

        try {
            //code...
            $this->productPriceService->delete(
                $productPrice
            );
            return redirect()->back()->with('success_status', 'Product Price deleted successfully.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error_status', 'Something went wrong. Please try again');
        }
    }

}