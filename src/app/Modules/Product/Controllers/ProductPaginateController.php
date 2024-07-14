<?php

namespace App\Modules\Product\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Product\Services\ProductService;
use Illuminate\Http\Request;

class ProductPaginateController extends Controller
{
    private $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function get(Request $request){
        $data = $this->productService->paginate($request->total ?? 10);
        return view('admin.pages.product.paginate', compact(['data']))
            ->with('search', $request->query('filter')['search'] ?? '');
    }

}