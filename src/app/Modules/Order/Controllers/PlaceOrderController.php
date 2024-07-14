<?php

namespace App\Modules\Order\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Cart\Models\Cart;
use App\Modules\Cart\Services\CartAmountService;
use App\Modules\Order\Requests\PlaceOrderRequest;
use App\Modules\Order\Resources\OrderGenerateCollection;
use App\Modules\Order\Services\OrderService;

class PlaceOrderController extends Controller
{
    private $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function post(PlaceOrderRequest $request){
        $cart_count = Cart::where('user_id', auth()->user()->id)->count();
        if($cart_count==0){
            return response()->json(["message" => "Your cart is empty. Please add items to cart!"], 400);
        }
        if((new CartAmountService())->get_total_price()>100000){
            return response()->json(["message" => "Max order amount allowed is ₹100000! Please remove some items from cart"], 400);
        }
        try {
            //code...
            $order = $this->orderService->place(
                $request->validated()
            );
            return response()->json([
                'message' => "Order placed successfully.",
                'order' => OrderGenerateCollection::make($order),
            ], 201);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Something went wrong. Please try again"], 400);
        }

    }
}