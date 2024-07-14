<?php

namespace App\Modules\Order\Controllers;

use App\Enums\PaymentMode;
use App\Enums\PaymentStatus;
use App\Http\Controllers\Controller;
use App\Http\Services\PayUService;
use App\Modules\Cart\Models\Cart;
use App\Modules\Order\Services\OrderService;
use Illuminate\Http\Request;

class PayUMoneyController extends Controller
{
    public function payUMoneyView(string $order_id)
    {
        $order = (new OrderService)->getOrderPlacedByIdPaymentPendingVia($order_id, PaymentMode::PAYU);

        $data = (new PayUService)->create_order($order);
        return view('payu.index')->with([
            'action' => $data['action'],
            'hash' => $data['hash'],
            'MERCHANT_KEY' => $data['MERCHANT_KEY'],
            'txnid' => $data['txnid'],
            'successURL' => $data['successURL'],
            'failURL' => $data['failURL'],
            'name' => $data['name'],
            'email' => $data['email'],
            'amount' => $data['amount']
        ]);
    }

    public function payUResponse($order_id, Request $request)
    {
        $order = (new OrderService)->getOrderPlacedByIdPaymentPendingVia($order_id, PaymentMode::PAYU);

        $rData = (new PayUService)->get_order((string) $order->id);
        if($rData->status == 1){
            (new OrderService)->updateOrderPayment([
                'payment_data' => json_encode($request->all()),
                'status' => PaymentStatus::PAID->value
            ], $order);

            Cart::where('user_id', $order->user_id)->delete();
            return redirect(route('payment_success'));
        }
        return redirect(route('payment_fail'));
    }

    public function payUCancel(Request $request)
    {
        return redirect(route('payment_fail'));
    }
}