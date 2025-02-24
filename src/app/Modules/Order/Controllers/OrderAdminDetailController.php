<?php

namespace App\Modules\Order\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Order\Services\OrderService;

class OrderAdminDetailController extends Controller
{
    private $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function get($id){
        $order = $this->orderService->getByIdForAdmin($id);
        return view('admin.pages.order.detail', compact(['order']))
        ->with([
            'order_statuses' => $order->statuses->pluck('status')->toArray(),
        ]);
    }
}
