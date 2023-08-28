<?php

namespace App\Modules\Order\Controllers;

use App\Enums\OrderEnumStatus;
use App\Enums\PaymentMode;
use App\Enums\PaymentStatus;
use App\Http\Controllers\Controller;
use App\Modules\Order\Models\OrderPayment;
use App\Modules\Order\Models\OrderStatus;
use App\Modules\Order\Services\OrderService;

class OrderAdminPaymentController extends Controller
{
    private $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->middleware('permission:list orders', ['only' => ['get']]);
        $this->orderService = $orderService;
    }

    public function get($id){
        $order = $this->orderService->getByIdAdmin($id);
        if($order->payment->status == PaymentStatus::PAID){
            return redirect()->back()->with('success_status', 'Payment paid already!');
        }
        $order_status = OrderStatus::where('order_id', $id)->orderBy('id', 'DESC')->get();
        if(in_array(OrderEnumStatus::CANCELLED, $order_status->pluck('status')->toArray())){
            return redirect()->back()->with('success_status', 'Order is cancelled already!');
        }else{
            OrderPayment::updateOrCreate(
                ['order_id' => $id],
                [
                    'mode' => PaymentMode::COD->value,
                    'status' => PaymentStatus::PAID->value,
                ]
            );
            return redirect()->back()->with('success_status', 'Payment paid successfully.');
        }
    }
}
