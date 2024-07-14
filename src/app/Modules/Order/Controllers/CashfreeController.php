<?php

namespace App\Modules\Order\Controllers;

use App\Enums\PaymentMode;
use App\Enums\PaymentStatus;
use App\Http\Controllers\Controller;
use App\Http\Services\CashfreeService;
use App\Modules\Cart\Models\Cart;
use App\Modules\Order\Services\OrderService;

class CashfreeController extends Controller
{
    public function cashfreeView(string $order_id)
    {
        $order = (new OrderService)->getOrderPlacedByIdPaymentPendingVia($order_id, PaymentMode::CASHFREE);
        $paymentSessionId = (new CashfreeService)->create_order($order);
        return view('cashfree.index')->with([
            'paymentSessionId' => $paymentSessionId
        ]);

    }

    public function cashfreeResponse($order_id)
    {
        $order = (new OrderService)->getOrderPlacedByIdPaymentPendingVia($order_id, PaymentMode::CASHFREE);

        try {
            $resp = (new CashfreeService)->get_order((string) $order->id);
            if($resp->order_status == "PAID"){
                (new OrderService)->updateOrderPayment([
                    'payment_data' => json_encode($resp),
                    'status' => PaymentStatus::PAID->value
                ], $order);

                Cart::where('user_id', $order->user_id)->delete();
                return redirect(route('payment_success'));
            }
            return redirect(route('payment_fail'));
        } catch (\Throwable $th) {
            return redirect(route('payment_fail'));
        }

    }
}