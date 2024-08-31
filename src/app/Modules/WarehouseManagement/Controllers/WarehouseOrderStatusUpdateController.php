<?php

namespace App\Modules\WarehouseManagement\Controllers;

use App\Enums\OrderEnumStatus;
use App\Http\Controllers\Controller;
use App\Modules\WarehouseManagement\Services\WarehouseManagementService;
use App\Modules\Order\Models\OrderStatus;
use Illuminate\Database\Eloquent\Collection;

class WarehouseOrderStatusUpdateController extends Controller
{
    private $service;

    public function __construct(WarehouseManagementService $service)
    {
        $this->service = $service;
    }

    public function get(string $order_id){
        $order = $this->service->getOrderById($order_id);
        $order_status = OrderStatus::where('order_id', $order_id)->orderBy('id', 'DESC')->get();
        if($this->checkOrderStatus($order_status, OrderEnumStatus::CANCELLED)){
            return redirect()->back()->with('error_status', "Order is cancelled already");
        }
        if(!$this->checkOrderStatus($order_status, OrderEnumStatus::CONFIRMED)){
            return redirect()->back()->with('error_status', "Order is not confirmed yet");
        }
        if($order->current_status->status==OrderEnumStatus::PACKED->value){
            return redirect()->back()->with('error_status', "Order is already packed");
        }
        OrderStatus::create([
            'status' => OrderEnumStatus::PACKED->value,
            'order_id' => $order_id,
        ]);
        return redirect()->route('warehouse_management.order.get')->with('success_status', "Order packed successfully");
    }

    private function checkOrderStatus(Collection $order_status, OrderEnumStatus $status): bool
    {
        return in_array($status, $order_status->pluck('status')->toArray());
    }
}
