<?php

namespace App\Modules\ProductVideo\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\ProductVideo\Services\ProductVideoService;
use Illuminate\Http\Request;

class ProductVideoPaginateController extends Controller
{
    private $productVideoService;

    public function __construct(ProductVideoService $productVideoService)
    {
        $this->productVideoService = $productVideoService;
    }

    public function get(Request $request, $product_id){
        $data = $this->productVideoService->paginate($request->total ?? 10, $product_id);
        return view('admin.pages.product_video.paginate', compact(['data', 'product_id']))
            ->with('search', $request->query('filter')['search'] ?? '');
    }

}
