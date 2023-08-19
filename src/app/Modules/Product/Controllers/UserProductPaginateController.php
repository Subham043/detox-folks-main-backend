<?php

namespace App\Modules\Product\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Product\Resources\UserProductCollection;
use App\Modules\Product\Services\ProductService;
use Illuminate\Http\Request;

class UserProductPaginateController extends Controller
{
    private $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function get(Request $request){
        $data = $this->productService->paginateMain($request->total ?? 10);
        return UserProductCollection::collection($data);
    }

}
