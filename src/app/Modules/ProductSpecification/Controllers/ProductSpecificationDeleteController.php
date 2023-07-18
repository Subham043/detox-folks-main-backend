<?php

namespace App\Modules\ProductSpecification\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\ProductSpecification\Services\ProductSpecificationService;

class ProductSpecificationDeleteController extends Controller
{
    private $productSpecificationService;

    public function __construct(ProductSpecificationService $productSpecificationService)
    {
        $this->middleware('permission:delete products', ['only' => ['get']]);
        $this->productSpecificationService = $productSpecificationService;
    }

    public function get($product_id, $id){
        $productSpecification = $this->productSpecificationService->getByProductIdAndId($product_id, $id);

        try {
            //code...
            $this->productSpecificationService->delete(
                $productSpecification
            );
            return redirect()->back()->with('success_status', 'Product Specification deleted successfully.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error_status', 'Something went wrong. Please try again');
        }
    }

}
