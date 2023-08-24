<?php

namespace App\Modules\Cart\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Cart\Resources\CartCollection;
use App\Modules\Cart\Requests\CartUpdateRequest;
use App\Modules\Cart\Services\CartAmountService;
use App\Modules\Cart\Services\CartService;
use App\Modules\Charge\Resources\UserChargeCollection;
use App\Modules\Tax\Resources\TaxCollection;

class CartUpdateController extends Controller
{
    private $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function post(CartUpdateRequest $request, $id){
        $cart = $this->cartService->getById($id);
        try {
            //code...
            $cart = $this->cartService->update(
                $request->validated(),
                $cart
            );
            return response()->json([
                'message' => "Cart updated successfully.",
                'cart' => CartCollection::make($this->cartService->getById($id)),
                'cart_subtotal' => (new CartAmountService())->get_subtotal(),
                'tax' => TaxCollection::make((new CartAmountService())->get_tax()),
                'total_tax' => (new CartAmountService())->get_tax_price(),
                'cart_charges' => UserChargeCollection::collection((new CartAmountService())->get_all_charges()),
                'total_charges' => (new CartAmountService())->get_charge_price(),
            ], 200);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Something went wrong. Please try again"], 400);
        }

    }
}
