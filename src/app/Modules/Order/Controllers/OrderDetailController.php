<?php

namespace App\Modules\Order\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Order\Resources\OrderCollection;
use App\Modules\Order\Services\OrderService;

class OrderDetailController extends Controller
{
    private $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function get($id){
        $order = $this->orderService->getById($id);
        return response()->json([
            'message' => "Order recieved successfully.",
            'order' => OrderCollection::make($order),
        ], 200);
    }
}
