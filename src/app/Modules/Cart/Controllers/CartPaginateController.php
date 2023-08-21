<?php

namespace App\Modules\Cart\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Cart\Resources\CartCollection;
use App\Modules\Cart\Services\CartService;
use Illuminate\Http\Request;

class CartPaginateController extends Controller
{
    private $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function get(Request $request){
        $data = $this->cartService->paginate($request->total ?? 10);
        return CartCollection::collection($data);
    }

}
