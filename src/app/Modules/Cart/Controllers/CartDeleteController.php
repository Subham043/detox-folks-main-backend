<?php

namespace App\Modules\Cart\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Cart\Resources\CartCollection;
use App\Modules\Cart\Services\CartAmountService;
use App\Modules\Cart\Services\CartService;
use App\Modules\Charge\Resources\UserChargeCollection;
use App\Modules\Tax\Resources\UserTaxCollection;

class CartDeleteController extends Controller
{
    private $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function delete($id){
        $cart = $this->cartService->getById($id);

        try {
            //code...
            $this->cartService->delete(
                $cart
            );
            return response()->json([
                'message' => "Cart deleted successfully.",
                'cart' => CartCollection::make($cart),
                'cart_subtotal' => (new CartAmountService())->get_subtotal(),
                'cart_charges' => UserChargeCollection::collection((new CartAmountService())->get_all_charges()),
                'total_charges' => (new CartAmountService())->get_charge_price(),
                'total_price' => (new CartAmountService())->get_total_price(),
            ], 200);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Something went wrong. Please try again"], 400);
        }
    }

}
