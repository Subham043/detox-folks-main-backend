<?php

namespace App\Modules\Order\Controllers;

use App\Enums\PaymentMode;
use App\Enums\PaymentStatus;
use App\Http\Controllers\Controller;
use App\Http\Services\RazorpayService;
use App\Modules\Cart\Services\CartService;
use App\Modules\Order\Requests\RazorpayVerifyPaymentRequest;
use App\Modules\Order\Services\OrderService;

class RazorpayController extends Controller
{

    public function get(string $order_id){
        $order = (new OrderService)->getOrderPlacedByIdPaymentPendingVia($order_id, PaymentMode::RAZORPAY);
        return view('razorpay.payment')->with([
            'order' => $order
        ]);
    }

    public function post(RazorpayVerifyPaymentRequest $request, string $order_id){

        $order = (new OrderService)->getOrderPlacedByIdPaymentPendingVia($order_id, PaymentMode::RAZORPAY);
        try {
            //code...
            (new OrderService)->updateOrderPayment([
                'razorpay_payment_id' => $request->razorpay_payment_id,
                'razorpay_signature' => $request->razorpay_signature,
                'payment_data' => json_encode((new RazorpayService)->get_payment_detail($request->razorpay_payment_id)),
                'status' => PaymentStatus::PAID->value
            ], $order);

            (new CartService)->empty($order->user_id);
            return redirect(route('payment_success'));
        } catch (\Throwable $th) {
            return redirect(route('payment_fail'));
        }

    }

}