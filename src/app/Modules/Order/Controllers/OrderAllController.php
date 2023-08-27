<?php

namespace App\Modules\Order\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Order\Resources\OrderCollection;
use App\Modules\Order\Services\OrderService;

class OrderAllController extends Controller
{
    private $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function get(){
        $data = $this->orderService->all();
        return response()->json([
            'message' => "Order recieved successfully.",
            'order' => OrderCollection::collection($data),
        ], 200);
    }

}
