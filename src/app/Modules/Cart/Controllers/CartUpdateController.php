<?php

namespace App\Modules\Cart\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Cart\Resources\CartCollection;
use App\Modules\Cart\Requests\CartUpdateRequest;
use App\Modules\Cart\Services\CartService;

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
                'cart' => CartCollection::make($cart),
            ], 200);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Something went wrong. Please try again"], 400);
        }

    }
}
