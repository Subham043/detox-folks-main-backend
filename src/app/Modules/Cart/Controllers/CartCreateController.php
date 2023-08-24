<?php

namespace App\Modules\Cart\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Cart\Requests\CartCreateRequest;
use App\Modules\Cart\Resources\CartCollection;
use App\Modules\Cart\Services\CartAmountService;
use App\Modules\Cart\Services\CartService;
use App\Modules\Charge\Resources\UserChargeCollection;
use App\Modules\Tax\Resources\TaxCollection;

class CartCreateController extends Controller
{
    private $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function post(CartCreateRequest $request){

        try {
            //code...
            $cart = $this->cartService->create(
                $request->validated()
            );
            return response()->json([
                'message' => "Cart created successfully.",
                'cart' => CartCollection::make($cart),
                'cart_subtotal' => (new CartAmountService())->get_subtotal(),
                'tax' => TaxCollection::make((new CartAmountService())->get_tax()),
                'total_tax' => (new CartAmountService())->get_tax_price(),
                'cart_charges' => UserChargeCollection::collection((new CartAmountService())->get_all_charges()),
                'total_charges' => (new CartAmountService())->get_charge_price(),
            ], 201);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Something went wrong. Please try again"], 400);
        }

    }
}
