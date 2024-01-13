<?php

namespace App\Modules\Order\Services;

use App\Enums\OrderEnumStatus;
use App\Enums\PaymentMode;
use App\Enums\PaymentStatus;
use App\Http\Services\PhonepeService;
use App\Http\Services\RazorpayService;
use App\Modules\BillingAddress\Models\BillingAddress;
use App\Modules\BillingInformation\Models\BillingInformation;
use App\Modules\Cart\Models\Cart;
use App\Modules\Cart\Services\CartAmountService;
use App\Modules\Cart\Services\CartService;
use App\Modules\Coupon\Models\AppliedCoupon;
use App\Modules\Coupon\Services\AppliedCouponService;
use App\Modules\Order\Models\Order;
use App\Modules\Order\Models\OrderCharge;
use App\Modules\Order\Models\OrderPayment;
use App\Modules\Order\Models\OrderProduct;
use App\Modules\Order\Models\OrderStatus;
use Illuminate\Database\Eloquent\Collection;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Ixudra\Curl\Facades\Curl;

class OrderService
{

    public function all(): Collection
    {
        return Order::with([
            'products',
            'charges',
            'statuses',
            'payment',
        ])->where('user_id', auth()->user()->id)->get();
    }

    public function paginate(Int $total = 10): LengthAwarePaginator
    {
        $query = Order::with([
            'products',
            'charges',
            'statuses',
            'payment',
        ])->where('user_id', auth()->user()->id)->latest();
        return QueryBuilder::for($query)
                ->paginate($total)
                ->appends(request()->query());
    }

    public function paginatePlaced(Int $total = 10): LengthAwarePaginator
    {
        $query = Order::with([
            'products',
            'charges',
            'statuses',
            'payment',
        ])->whereHas('payment', function($qry){
            $qry->where(function($q){
                $q->where('mode', PaymentMode::COD);
            })->orWhere(function($q){
                $q->where(function($qr){
                    $qr->where('mode', PaymentMode::PHONEPE)->orWhere('mode', PaymentMode::RAZORPAY);
                })->where('status', '<>', PaymentStatus::PENDING);
            });
        })->where('user_id', auth()->user()->id)->latest();
        return QueryBuilder::for($query)
                ->paginate($total)
                ->appends(request()->query());
    }

    public function paginateOrderProducts(Int $total = 10): LengthAwarePaginator
    {
        $query = OrderProduct::with([
            'product' => function($qry){
                $qry->with([
                    'categories',
                    'sub_categories',
                    'product_specifications',
                    'product_images',
                    'product_prices'=>function($q){
                        $q->orderBy('min_quantity', 'asc');
                    },
                ]);
            },
            'order' => function($qry) {
                $qry->where('user_id', auth()->user()->id);
            },
        ])->whereHas('product', function($qry){
            $qry->with([
                'categories',
                'sub_categories',
                'product_specifications',
                'product_images',
                'product_prices'=>function($q){
                    $q->orderBy('min_quantity', 'asc');
                },
            ]);
        })->groupBy('slug')->latest();
        return QueryBuilder::for($query)
                ->paginate($total)
                ->appends(request()->query());
    }

    public function paginate_admin(Int $total = 10): LengthAwarePaginator
    {
        $query = Order::with([
            'products',
            'charges',
            'statuses',
            'payment',
        ]);
        return QueryBuilder::for($query)
        ->allowedIncludes(['products', 'charges', 'statuses', 'payment'])
                ->defaultSort('-id')
                ->allowedSorts('id', 'total_price')
                ->allowedFilters([
                    AllowedFilter::callback('has_status', function (Builder $query, $value) {
                        if($value!='all'){
                            $query->whereHas('statuses', function($q) use($value) {
                                $q->where('status', $value);
                            });
                        }
                    }),
                    AllowedFilter::callback('has_payment_status', function (Builder $query, $value) {
                        if($value!='all'){
                            $query->whereHas('payment', function($q) use($value) {
                                $q->where('status', $value);
                            });
                        }
                    }),
                    AllowedFilter::custom('search', new CommonFilter),
                ])
                ->paginate($total)
                ->appends(request()->query());
    }

    public function getById(Int $id): Order|null
    {
        return Order::with([
            'products',
            'charges',
            'statuses',
            'payment',
        ])->where('user_id', auth()->user()->id)->findOrFail($id);
    }

    public function getOrderPlacedById(Int $id): Order|null
    {
        return Order::with([
            'products',
            'charges',
            'statuses',
            'payment',
        ])->whereHas('payment', function($qry){
            $qry->where(function($q){
                $q->where('mode', PaymentMode::COD);
            })->orWhere(function($q){
                $q->where(function($qr){
                    $qr->where('mode', PaymentMode::PHONEPE)->orWhere('mode', PaymentMode::RAZORPAY);
                })->where('status', '<>', PaymentStatus::PENDING);
            });
        })->where('user_id', auth()->user()->id)->findOrFail($id);
    }

    public function getByIdAdmin(Int $id): Order|null
    {
        return Order::with([
            'products',
            'charges',
            'statuses',
            'payment',
        ])->findOrFail($id);
    }

    public function place(array $data): Order
    {
        $billingInformation = BillingInformation::findOrFail($data['billing_information_id']);
        $billingAddress = BillingAddress::findOrFail($data['billing_address_id']);
        $order = Order::create([
            'name' => $billingInformation->name,
            'email' => $billingInformation->email,
            'phone' => $billingInformation->phone,
            'gst' => $billingInformation->gst,
            'country' => $billingAddress->country,
            'state' => $billingAddress->state,
            'city' => $billingAddress->city,
            'pin' => $billingAddress->pin,
            'address' => $billingAddress->address,
            'accept_terms' => $data['accept_terms'],
            'include_gst' => $data['include_gst'],
            'order_mode' => $data['order_mode'],
            'subtotal' => (new CartAmountService())->get_subtotal(),
            'total_tax' => (new CartAmountService())->get_tax_price(),
            'total_charges' => (new CartAmountService())->get_charge_price(),
            'discount_price' => (new CartAmountService())->get_discount_price(),
            'total_price' => (new CartAmountService())->get_total_price(),
            'coupon_name' => !empty((new AppliedCouponService)->getCouponApplied()) ? (new AppliedCouponService)->getCouponApplied()->coupon->coupon_name : null,
            'coupon_code' => !empty((new AppliedCouponService)->getCouponApplied()) ? (new AppliedCouponService)->getCouponApplied()->coupon->coupon_code : null,
            'coupon_description' => !empty((new AppliedCouponService)->getCouponApplied()) ? (new AppliedCouponService)->getCouponApplied()->coupon->coupon_description : null,
            'coupon_discount' => !empty((new AppliedCouponService)->getCouponApplied()) ? (new AppliedCouponService)->getCouponApplied()->coupon->coupon_discount : null,
            'coupon_maximum_dicount_in_price' => !empty((new AppliedCouponService)->getCouponApplied()) ? (new AppliedCouponService)->getCouponApplied()->coupon->coupon_maximum_dicount_in_price : null,
            'coupon_maximum_number_of_use' => !empty((new AppliedCouponService)->getCouponApplied()) ? (new AppliedCouponService)->getCouponApplied()->coupon->coupon_maximum_number_of_use : null,
            'coupon_minimum_cart_value' => !empty((new AppliedCouponService)->getCouponApplied()) ? (new AppliedCouponService)->getCouponApplied()->coupon->coupon_minimum_cart_value : null,
            'tax_slug' => (new CartAmountService())->get_tax()->tax_slug,
            'tax_name' => (new CartAmountService())->get_tax()->tax_name,
            'tax_in_percentage' => (new CartAmountService())->get_tax()->tax_in_percentage,
        ]);
        $order->user_id = auth()->user()->id;
        $order->save();
        $carts = (new CartService)->all();
        foreach ($carts as $cart) {
            # code...
            OrderProduct::create([
                'name' => $cart->product->name,
                'slug' => $cart->product->slug,
                'brief_description' => $cart->product->brief_description,
                'image' => $cart->product->image,
                'min_quantity' => $cart->product_price->min_quantity,
                'price' => $cart->product_price->price,
                'discount' => $cart->product_price->discount,
                'discount_in_price' => $cart->product_price->discount_in_price,
                'quantity' => $cart->quantity,
                'amount' => $cart->amount,
                'unit' => $cart->product->cart_quantity_specification,
                'order_id' => $order->id,
            ]);
        }
        $charges = (new CartAmountService())->get_all_charges();
        foreach ($charges as $charge) {
            # code...
            OrderCharge::create([
                'charges_name' => $charge->charges_name,
                'charges_slug' => $charge->charges_slug,
                'charges_in_amount' => $charge->charges_in_amount,
                'include_charges_for_cart_price_below' => $charge->include_charges_for_cart_price_below,
                'order_id' => $order->id,
            ]);
        }
        if($data['mode_of_payment'] == PaymentMode::RAZORPAY->value){
            OrderPayment::create([
                'mode' => $data['mode_of_payment'],
                'status' => PaymentStatus::PENDING->value,
                'razorpay_order_id' => (new RazorpayService)->create_order_id($order->total_price, $order->id),
                'order_id' => $order->id,
            ]);
        }else{
            OrderPayment::create([
                'mode' => $data['mode_of_payment'],
                'status' => PaymentStatus::PENDING->value,
                'order_id' => $order->id,
            ]);
        }
        OrderStatus::create([
            'status' => OrderEnumStatus::PROCESSING->value,
            'order_id' => $order->id,
        ]);
        if($data['mode_of_payment'] == PaymentMode::COD->value){
            Cart::where('user_id', auth()->user()->id)->delete();
            AppliedCoupon::where('user_id', auth()->user()->id)->delete();
        }
        return Order::with([
            'products',
            'charges',
            'statuses',
            'payment',
        ])->where('user_id', auth()->user()->id)->findOrFail($order->id);
    }

    public function update(array $data, Order $order): Order
    {
        $order->update($data);
        return $order;
    }

    public function delete(Order $order): bool|null
    {
        return $order->delete();
    }

    public function phone_pe_response(array $input): string
    {
        return (new PhonepeService)->verify($input);
    }

    public function get_phone_pe_link(Order $order): string|null
    {
        return $order->payment->mode==PaymentMode::PHONEPE ? (new PhonepeService)->generate($order->id, $order->total_price) : null;
    }

}

class CommonFilter implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {
        $query->where(function($qr) use($value){
            $qr->where('name', 'LIKE', '%' . $value . '%')
            ->orWhere('id', 'LIKE', '%' . $value . '%')
            ->orWhere('email', 'LIKE', '%' . $value . '%')
            ->orWhere('phone', 'LIKE', '%' . $value . '%')
            ->orWhere('total_price', 'LIKE', '%' . $value . '%')
            ->whereHas('products', function($q) use($value) {
                $q->where('name', 'LIKE', '%' . $value . '%');
            });
        });
    }
}
