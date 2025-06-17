<?php

namespace App\Modules\ProductVideo\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\ProductVideo\Services\ProductVideoService;

class ProductVideoDeleteController extends Controller
{
    private $productVideoService;

    public function __construct(ProductVideoService $productVideoService)
    {
        $this->productVideoService = $productVideoService;
    }

    public function get($product_id, $id){
        $productVideo = $this->productVideoService->getByProductIdAndId($product_id, $id);

        try {
            //code...
            $this->productVideoService->delete(
                $productVideo
            );
            return redirect()->back()->with('success_status', 'Product Video deleted successfully.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error_status', 'Something went wrong. Please try again');
        }
    }

}
