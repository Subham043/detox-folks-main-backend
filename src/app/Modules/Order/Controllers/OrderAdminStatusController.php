<?php

namespace App\Modules\Order\Controllers;

use App\Enums\OrderEnumStatus;
use App\Http\Controllers\Controller;
use App\Modules\Order\Models\OrderStatus;
use App\Modules\Order\Services\OrderService;

class OrderAdminStatusController extends Controller
{
    private $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->middleware('permission:list orders', ['only' => ['get']]);
        $this->orderService = $orderService;
    }

    public function get($id){
        $this->orderService->getByIdAdmin($id);
        $order_status = OrderStatus::where('order_id', $id)->orderBy('id', 'DESC')->get();
        if(in_array(OrderEnumStatus::CANCELLED, $order_status->pluck('status')->toArray())){
            return redirect()->back()->with('success_status', 'Order is cancelled already!');
        }else{
            if(!in_array(OrderEnumStatus::CONFIRMED, $order_status->pluck('status')->toArray())){
                OrderStatus::create([
                    'status' => OrderEnumStatus::CONFIRMED->value,
                    'order_id' => $id,
                ]);
                return redirect()->back()->with('success_status', 'Order confirmed successfully.');
            }elseif(!in_array(OrderEnumStatus::PACKED, $order_status->pluck('status')->toArray())){
                OrderStatus::create([
                    'status' => OrderEnumStatus::PACKED->value,
                    'order_id' => $id,
                ]);
                return redirect()->back()->with('success_status', 'Order is out for delivery.');
            }elseif(!in_array(OrderEnumStatus::READY, $order_status->pluck('status')->toArray())){
                OrderStatus::create([
                    'status' => OrderEnumStatus::READY->value,
                    'order_id' => $id,
                ]);
                return redirect()->back()->with('success_status', 'Order is out for delivery.');
            }elseif(!in_array(OrderEnumStatus::OFD, $order_status->pluck('status')->toArray())){
                OrderStatus::create([
                    'status' => OrderEnumStatus::OFD->value,
                    'order_id' => $id,
                ]);
                return redirect()->back()->with('success_status', 'Order is out for delivery.');
            }elseif(!in_array(OrderEnumStatus::DELIVERED, $order_status->pluck('status')->toArray())){
                OrderStatus::create([
                    'status' => OrderEnumStatus::DELIVERED->value,
                    'order_id' => $id,
                ]);
                return redirect()->back()->with('success_status', 'Order delivered successfully.');
            }
        }
    }
}