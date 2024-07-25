<?php

namespace App\Modules\Enquiry\OrderForm\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Enquiry\OrderForm\Requests\OrderFormRequest;
use App\Modules\Enquiry\OrderForm\Resources\OrderFormCollection;
use App\Modules\Enquiry\OrderForm\Services\OrderFormService;
use App\Modules\Order\Services\OrderService;

class OrderFormCreateController extends Controller
{
    private $orderFormService;

    public function __construct(OrderFormService $orderFormService)
    {
        $this->orderFormService = $orderFormService;
    }

    public function post(OrderFormRequest $request, string $order_id){
        (new OrderService)->getById($order_id);
        try {
            //code...
            $orderForm = $this->orderFormService->create(
                [
                    ...$request->validated(),
                    'order_id' => $order_id
                ]
            );

            return response()->json([
                'message' => "Enquiry created successfully.",
                'orderForm' => OrderFormCollection::make($orderForm),
            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => "Something went wrong. Please try again",
            ], 400);
        }

    }
}