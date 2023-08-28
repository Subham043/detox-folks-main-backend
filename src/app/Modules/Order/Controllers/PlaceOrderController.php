<?php

namespace App\Modules\Order\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Order\Requests\PlaceOrderRequest;
use App\Modules\Order\Resources\OrderCollection;
use App\Modules\Order\Services\OrderService;

class PlaceOrderController extends Controller
{
    private $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function post(PlaceOrderRequest $request){
        try {
            //code...
            $order = $this->orderService->place(
                $request->validated()
            );
            return response()->json([
                'message' => "Order placed successfully.",
                'order' => OrderCollection::make($order),
            ], 201);
        } catch (\Throwable $th) {
            throw $th;
            return response()->json(["message" => "Something went wrong. Please try again"], 400);
        }

    }
}
