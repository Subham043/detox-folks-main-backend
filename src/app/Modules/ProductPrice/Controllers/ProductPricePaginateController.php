<?php

namespace App\Modules\ProductPrice\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\ProductPrice\Services\ProductPriceService;
use Illuminate\Http\Request;

class ProductPricePaginateController extends Controller
{
    private $productPriceService;

    public function __construct(ProductPriceService $productPriceService)
    {
        $this->middleware('permission:list products', ['only' => ['get']]);
        $this->productPriceService = $productPriceService;
    }

    public function get(Request $request, $product_id){
        $data = $this->productPriceService->paginate($request->total ?? 10, $product_id);
        return view('admin.pages.product_price.paginate', compact(['data', 'product_id']))
            ->with('search', $request->query('filter')['search'] ?? '');
    }

}
