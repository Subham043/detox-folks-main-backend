<?php

namespace App\Modules\Order\Controllers;

use App\Enums\PaymentMode;
use App\Enums\PaymentStatus;
use App\Http\Controllers\Controller;
use App\Modules\Cart\Models\Cart;
use App\Modules\Order\Models\Order;
use App\Modules\Order\Requests\RazorpayVerifyPaymentRequest;

class RazorpayController extends Controller
{

    public function get(string $order_id){
        $order = Order::with([
            'products',
            'charges',
            'statuses',
            'payment',
        ])->whereHas('payment', function($qry){
            $qry->where('mode', PaymentMode::RAZORPAY)->where('status', PaymentStatus::PENDING);
        })->findOrFail($order_id);
        return view('razorpay.payment')->with([
            'order' => $order
        ]);
    }

    public function post(RazorpayVerifyPaymentRequest $request, string $order_id){

        $order = Order::with([
            'products',
            'charges',
            'statuses',
            'payment',
        ])->whereHas('payment', function($qry) use($request){
            $qry->where('mode', PaymentMode::RAZORPAY)->where('status', PaymentStatus::PENDING)->where('razorpay_order_id', $request->razorpay_order_id);
        })->findOrFail($order_id);

        try {
            //code...
            $order->payment->update([
                'razorpay_payment_id' => $request->razorpay_payment_id,
                'razorpay_signature' => $request->razorpay_signature,
                'status' => PaymentStatus::PAID->value
            ]);

            Cart::where('user_id', $order->user_id)->delete();

            return response()->json([
                'message' => "Payment done successfully.",
            ], 200);
        } catch (\Throwable $th) {
            throw $th;
            return response()->json([
                'message' => "Something went wrong. Please try again",
            ], 400);
        }

    }

}
