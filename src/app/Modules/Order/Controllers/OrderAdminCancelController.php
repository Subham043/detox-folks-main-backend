<?php

namespace App\Modules\Order\Controllers;

use App\Enums\OrderEnumStatus;
use App\Enums\PaymentMode;
use App\Enums\PaymentStatus;
use App\Http\Controllers\Controller;
use App\Modules\Order\Models\OrderPayment;
use App\Modules\Order\Models\OrderStatus;
use App\Modules\Order\Services\OrderService;

class OrderAdminCancelController extends Controller
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
            OrderStatus::create([
                'status' => OrderEnumStatus::CANCELLED->value,
                'order_id' => $id,
            ]);
            OrderPayment::updateOrCreate(
                ['order_id' => $id],
                [
                    'mode' => PaymentMode::COD->value,
                    'status' => PaymentStatus::REFUND->value,
                ]
            );
            return redirect()->back()->with('success_status', 'Order cancelled successfully.');
        }
    }
}
