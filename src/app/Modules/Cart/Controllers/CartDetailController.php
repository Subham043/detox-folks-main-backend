<?php

namespace App\Modules\Cart\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Cart\Resources\CartCollection;
use App\Modules\Cart\Services\CartAmountService;
use App\Modules\Cart\Services\CartService;
use App\Modules\Charge\Resources\UserChargeCollection;
use App\Modules\Tax\Resources\UserTaxCollection;

class CartDetailController extends Controller
{
    private $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function get($id){
        $cart = $this->cartService->getById($id);
        return response()->json([
            'message' => "Cart recieved successfully.",
            'cart' => CartCollection::make($cart),
            'cart_subtotal' => (new CartAmountService())->get_subtotal(),
            'tax_charges' => UserTaxCollection::collection((new CartAmountService())->get_all_taxes()),
            'total_taxes' => (new CartAmountService())->get_tax_price(),
            'cart_charges' => UserChargeCollection::collection((new CartAmountService())->get_all_charges()),
            'total_charges' => (new CartAmountService())->get_charge_price(),
            'total_price' => (new CartAmountService())->get_total_price(),
        ], 200);
    }
}
