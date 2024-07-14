<?php

namespace App\Modules\ProductImage\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\ProductImage\Services\ProductImageService;
use Illuminate\Http\Request;

class ProductImagePaginateController extends Controller
{
    private $productImageService;

    public function __construct(ProductImageService $productImageService)
    {
        $this->productImageService = $productImageService;
    }

    public function get(Request $request, $product_id){
        $data = $this->productImageService->paginate($request->total ?? 10, $product_id);
        return view('admin.pages.product_image.paginate', compact(['data', 'product_id']))
            ->with('search', $request->query('filter')['search'] ?? '');
    }

}