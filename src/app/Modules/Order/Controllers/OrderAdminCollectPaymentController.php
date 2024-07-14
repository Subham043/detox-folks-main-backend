<?php

namespace App\Modules\Order\Controllers;

use App\Enums\PaymentMode;
use App\Enums\PaymentStatus;
use App\Http\Controllers\Controller;
use App\Modules\Order\Services\OrderService;

class OrderAdminCollectPaymentController extends Controller
{
    private $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function get($id){
        $order = $this->orderService->getByIdForAdmin($id);
        if($order->payment->status == PaymentStatus::PAID){
            return redirect()->back()->with('error_status', 'Payment paid already!');
        }
        $order_payment = $this->orderService->collectCodOrderPayment($id);
        return redirect()->back()->with('success_status', $order_payment);
    }
}