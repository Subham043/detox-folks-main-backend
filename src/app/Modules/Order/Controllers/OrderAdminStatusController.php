<?php

namespace App\Modules\Order\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Order\Services\OrderService;

class OrderAdminStatusController extends Controller
{
    private $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function get($id){
        $this->orderService->getByIdForAdmin($id);
        $order_status = $this->orderService->updateOrderStatus($id);
        return redirect()->back()->with('success_status', $order_status);
    }
}