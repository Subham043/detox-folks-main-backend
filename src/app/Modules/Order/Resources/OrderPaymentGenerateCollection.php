<?php

namespace App\Modules\Order\Resources;

use App\Enums\PaymentMode;
use App\Modules\Order\Services\OrderService;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderPaymentGenerateCollection extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'mode' => $this->mode,
            'status' => $this->status,
            'phone_pe_payment_link' => $this->mode==PaymentMode::PHONEPE ? (new OrderService)->get_phone_pe_link($this->order) : null,
            'razorpay_order_id' => $this->razorpay_order_id,
            'razorpay_payment_link' => $this->mode==PaymentMode::RAZORPAY ? route('make_razorpay_payment', $this->order->id) : null,
            'payu_payment_link' => $this->mode==PaymentMode::PAYU ? route('make_payu_payment', $this->order->id) : null,
            'cashfree_payment_link' => $this->mode==PaymentMode::CASHFREE ? route('make_cashfree_payment', $this->order->id) : null,
            'created_at' => $this->created_at->diffForHumans(),
            'updated_at' => $this->updated_at->diffForHumans(),
        ];
    }
}