<?php

namespace App\Modules\WarehouseManagement\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\WarehouseManagement\Services\WarehouseManagementService;

class WarehouseOrderDetailController extends Controller
{
    private $service;

    public function __construct(WarehouseManagementService $service)
    {
        $this->service = $service;
    }

    public function get(string $order_id){
        $order = $this->service->getOrderById($order_id);
        return view('admin.pages.warehouse_management.detail', compact(['order']))->with([
            'order_statuses' => $order->statuses->pluck('status')->toArray(),
        ]);
    }
}
