<?php

namespace App\Modules\ProductColor\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\ProductColor\Services\ProductColorService;
use Illuminate\Http\Request;

class ProductColorPaginateController extends Controller
{
    private $productColorService;

    public function __construct(ProductColorService $productColorService)
    {
        $this->productColorService = $productColorService;
    }

    public function get(Request $request, $product_id){
        $data = $this->productColorService->paginate($request->total ?? 10, $product_id);
        return view('admin.pages.product_color.paginate', compact(['data', 'product_id']))
            ->with('search', $request->query('filter')['search'] ?? '');
    }

}
