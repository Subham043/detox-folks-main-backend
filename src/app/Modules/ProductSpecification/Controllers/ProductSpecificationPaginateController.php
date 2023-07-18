<?php

namespace App\Modules\ProductSpecification\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\ProductSpecification\Services\ProductSpecificationService;
use Illuminate\Http\Request;

class ProductSpecificationPaginateController extends Controller
{
    private $productSpecificationService;

    public function __construct(ProductSpecificationService $productSpecificationService)
    {
        $this->middleware('permission:list products', ['only' => ['get']]);
        $this->productSpecificationService = $productSpecificationService;
    }

    public function get(Request $request, $product_id){
        $data = $this->productSpecificationService->paginate($request->total ?? 10, $product_id);
        return view('admin.pages.product_specification.paginate', compact(['data', 'product_id']))
            ->with('search', $request->query('filter')['search'] ?? '');
    }

}
