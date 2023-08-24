<?php

namespace App\Modules\Cart\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Cart\Resources\CartCollection;
use App\Modules\Cart\Services\CartAmountService;
use App\Modules\Cart\Services\CartService;

class CartAllController extends Controller
{
    private $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function get(){
        $data = $this->cartService->all();
        return response()->json([
            'message' => "Cart recieved successfully.",
            'cart' => CartCollection::collection($data),
            'cart_subtotal' => (new CartAmountService())->get_subtotal(),
        ], 200);
    }

}
