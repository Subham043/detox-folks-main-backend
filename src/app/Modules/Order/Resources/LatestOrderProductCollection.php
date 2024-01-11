<?php

namespace App\Modules\Order\Resources;

use App\Modules\Product\Resources\UserProductCollection;
use Illuminate\Http\Resources\Json\JsonResource;

class LatestOrderProductCollection extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return UserProductCollection::make($this->product);
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'country' => $this->country,
            'state' => $this->state,
            'city' => $this->city,
            'pin' => $this->pin,
            'address' => $this->address,
            'coupon_name' => $this->coupon_name,
            'coupon_code' => $this->coupon_code,
            'coupon_description' => $this->coupon_description,
            'coupon_discount' => $this->coupon_discount,
            'coupon_maximum_dicount_in_price' => $this->coupon_maximum_dicount_in_price,
            'coupon_maximum_number_of_use' => $this->coupon_maximum_number_of_use,
            'coupon_minimum_cart_value' => $this->coupon_minimum_cart_value,
            'tax_slug' => $this->tax_slug,
            'tax_name' => $this->tax_name,
            'tax_in_percentage' => $this->tax_in_percentage,
            'subtotal' => $this->subtotal,
            'total_tax' => $this->total_tax,
            'total_charges' => $this->total_charges,
            'discount_price' => $this->discount_price,
            'total_price' => $this->total_price,
            'order_mode' => $this->order_mode,
            'products' => OrderProductCollection::collection($this->products),
            'charges' => OrderChargeCollection::collection($this->charges),
            'statuses' => OrderStatusCollection::collection($this->statuses),
            'payment' => OrderPaymentCollection::make($this->payment),
            'created_at' => $this->created_at->diffForHumans(),
            'updated_at' => $this->updated_at->diffForHumans(),
        ];
    }
}
