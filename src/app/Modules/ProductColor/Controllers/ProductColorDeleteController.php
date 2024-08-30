<?php

namespace App\Modules\ProductColor\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\ProductColor\Services\ProductColorService;

class ProductColorDeleteController extends Controller
{
    private $productColorService;

    public function __construct(ProductColorService $productColorService)
    {
        $this->productColorService = $productColorService;
    }

    public function get($product_id, $id){
        $productColor = $this->productColorService->getByProductIdAndId($product_id, $id);

        try {
            //code...
            $this->productColorService->delete(
                $productColor
            );
            return redirect()->back()->with('success_status', 'Product Color deleted successfully.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error_status', 'Something went wrong. Please try again');
        }
    }

}
