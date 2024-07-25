<?php

namespace App\Modules\Order\Services;

use App\Enums\OrderEnumStatus;
use App\Enums\PaymentMode;
use App\Enums\PaymentStatus;
use App\Http\Services\CashfreeService;
use App\Http\Services\PayUService;
use App\Http\Services\PhonepeService;
use App\Http\Services\RazorpayService;
use App\Modules\BillingAddress\Models\BillingAddress;
use App\Modules\BillingInformation\Models\BillingInformation;
use App\Modules\Cart\Services\CartAmountService;
use App\Modules\Cart\Services\CartService;
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

class OrderService
{

    public function all(): Collection
    {
        return Order::commonWith()->placedByUser()->get();
    }

    public function paginateLatestPlacedByUser(Int $total = 10): LengthAwarePaginator
    {
        $query = Order::commonWith()->placedByUser()->latest();
        return QueryBuilder::for($query)
                ->paginate($total)
                ->appends(request()->query());
    }

    public function paginateLatestPlacedByUserPaymentCompleted(Int $total = 10): LengthAwarePaginator
    {
        $query = Order::commonWith()->paymentCompleted()->placedByUser()->latest();
        return QueryBuilder::for($query)
                ->paginate($total)
                ->appends(request()->query());
    }

    public function paginateRecentlyOrderedProducts(Int $total = 10): LengthAwarePaginator
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
                $qry->placedByUser();
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

    public function paginateForAdmin(Int $total = 10): LengthAwarePaginator
    {
        return QueryBuilder::for(Order::commonWith())
        ->allowedIncludes(['products', 'charges', 'statuses', 'current_status', 'payment'])
                ->defaultSort('-id')
                ->allowedSorts('id', 'total_price')
                ->allowedFilters([
                    AllowedFilter::callback('has_status', function (Builder $query, $value) {
                        if($value!='all'){
                            $query->whereHas('current_status', function($q) use($value) {
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
                    AllowedFilter::callback('has_payment_mode', function (Builder $query, $value) {
                        if($value!='all'){
                            $query->whereHas('payment', function($q) use($value) {
                                $q->where('mode', $value);
                            });
                        }
                    }),
                    AllowedFilter::callback('has_date', function (Builder $query, $value) {
                        $date = explode(' - ', $value);
                        $query->whereBetween('created_at', [...$date]);
                    }),
                    AllowedFilter::custom('search', new CommonFilter),
                ])
                ->paginate($total)
                ->appends(request()->query());
    }

    public function orderCountAdmin(): int
    {
        return QueryBuilder::for(Order::commonWith())
        ->allowedIncludes(['products', 'charges', 'statuses', 'current_status', 'payment'])
                ->defaultSort('-id')
                ->allowedSorts('id', 'total_price')
                ->allowedFilters([
                    AllowedFilter::callback('has_status', function (Builder $query, $value) {
                        if($value!='all'){
                            $query->whereHas('current_status', function($q) use($value) {
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
                    AllowedFilter::callback('has_payment_mode', function (Builder $query, $value) {
                        if($value!='all'){
                            $query->whereHas('payment', function($q) use($value) {
                                $q->where('mode', $value);
                            });
                        }
                    }),
                    AllowedFilter::callback('has_date', function (Builder $query, $value) {
                        $date = explode(' - ', $value);
                        $query->whereBetween('created_at', [...$date]);
                    }),
                    AllowedFilter::custom('search', new CommonFilter),
                ])
                ->count();
    }

    public function earningCountAdmin(): int
    {
        return QueryBuilder::for(Order::commonWith()->whereHas('payment', function($q) {
            $q->where('status', PaymentStatus::PAID);
        }))
        ->allowedIncludes(['products', 'charges', 'statuses', 'current_status', 'payment'])
                ->defaultSort('-id')
                ->allowedSorts('id', 'total_price')
                ->allowedFilters([
                    AllowedFilter::callback('has_status', function (Builder $query, $value) {
                        if($value!='all'){
                            $query->whereHas('current_status', function($q) use($value) {
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
                    AllowedFilter::callback('has_payment_mode', function (Builder $query, $value) {
                        if($value!='all'){
                            $query->whereHas('payment', function($q) use($value) {
                                $q->where('mode', $value);
                            });
                        }
                    }),
                    AllowedFilter::callback('has_date', function (Builder $query, $value) {
                        $date = explode(' - ', $value);
                        $query->whereBetween('created_at', [...$date]);
                    }),
                    AllowedFilter::custom('search', new CommonFilter),
                ])
                ->sum('total_price');
    }

    public function lossCountAdmin(): int
    {
        return QueryBuilder::for(Order::commonWith()->whereHas('payment', function($q) {
            $q->where('status', PaymentStatus::REFUND);
        }))
        ->allowedIncludes(['products', 'charges', 'statuses', 'current_status', 'payment'])
                ->defaultSort('-id')
                ->allowedSorts('id', 'total_price')
                ->allowedFilters([
                    AllowedFilter::callback('has_status', function (Builder $query, $value) {
                        if($value!='all'){
                            $query->whereHas('current_status', function($q) use($value) {
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
                    AllowedFilter::callback('has_payment_mode', function (Builder $query, $value) {
                        if($value!='all'){
                            $query->whereHas('payment', function($q) use($value) {
                                $q->where('mode', $value);
                            });
                        }
                    }),
                    AllowedFilter::callback('has_date', function (Builder $query, $value) {
                        $date = explode(' - ', $value);
                        $query->whereBetween('created_at', [...$date]);
                    }),
                    AllowedFilter::custom('search', new CommonFilter),
                ])
                ->sum('total_price');
    }

    public function getById($id): Order|null
    {
        return Order::commonWith()->placedByUser()->findOrFail($id);
    }

    public function getOrderPlacedById($id): Order|null
    {
        return Order::commonWith()->paymentCompleted()->placedByUser()->findOrFail($id);
    }

    public function getOrderPlacedByIdPaymentPendingVia($id, PaymentMode $paymentMode): Order|null
    {
        return Order::commonWith()->paymentPendingFrom($id, $paymentMode)->findOrFail($id);
    }

    public function getByIdForAdmin($id): Order|null
    {
        return Order::commonWith()->findOrFail($id);
    }

    public function place(array $data): Order
    {
        $billingInformation = BillingInformation::findOrFail($data['billing_information_id']);
        $billingAddress = BillingAddress::findOrFail($data['billing_address_id']);
        DB::beginTransaction();
        try {
            //code...
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
                'total_charges' => (new CartAmountService())->get_charge_price(),
                'total_price' => (new CartAmountService())->get_total_price(),
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
                    'is_percentage' => $charge->is_percentage,
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
                'status' => OrderEnumStatus::PLACED->value,
                'order_id' => $order->id,
            ]);
            if($data['mode_of_payment'] == PaymentMode::COD->value){
                (new CartService)->empty(auth()->user()->id);
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        } finally {
            DB::commit();
        }
        return Order::commonWith()->placedByUser()->findOrFail($order->id);
    }

    public function update(array $data, Order $order): Order
    {
        $order->update($data);
        return $order;
    }

    public function updateOrderPayment(array $data, Order $order): Order
    {
        $order->payment->update($data);
        return $order;
    }

    public function delete(Order $order): bool|null
    {
        return $order->delete();
    }

    public function phone_pe_response(array $input): string
    {
        $order = $this->getOrderPlacedByIdPaymentPendingVia($input['transactionId'], PaymentMode::PHONEPE);
        (new CartService)->empty($order->user_id);
        return (new PhonepeService)->verify($input, $order);
    }

    public function get_phone_pe_link(Order $order): string|null
    {
        return $order->payment->mode==PaymentMode::PHONEPE ? (new PhonepeService)->generate($order->id, $order->user_id, $order->total_price) : null;
    }

    public function checkOrderStatus(Collection $order_status, OrderEnumStatus $status): bool
    {
        return in_array($status, $order_status->pluck('status')->toArray());
    }

    public function updateOrderStatus(string $id): string
    {
        $order_status = OrderStatus::where('order_id', $id)->orderBy('id', 'DESC')->get();
        if($this->checkOrderStatus($order_status, OrderEnumStatus::CANCELLED)){
            return 'Order is cancelled already!';
        }else{
            if(!$this->checkOrderStatus($order_status, OrderEnumStatus::CONFIRMED)){
                OrderStatus::create([
                    'status' => OrderEnumStatus::CONFIRMED->value,
                    'order_id' => $id,
                ]);
                return 'Order confirmed successfully.';
            }elseif(!$this->checkOrderStatus($order_status, OrderEnumStatus::PACKED)){
                OrderStatus::create([
                    'status' => OrderEnumStatus::PACKED->value,
                    'order_id' => $id,
                ]);
                return 'Order is out for delivery.';
            }elseif(!$this->checkOrderStatus($order_status, OrderEnumStatus::READY)){
                OrderStatus::create([
                    'status' => OrderEnumStatus::READY->value,
                    'order_id' => $id,
                ]);
                return 'Order is out for delivery.';
            }elseif(!$this->checkOrderStatus($order_status, OrderEnumStatus::OFD)){
                OrderStatus::create([
                    'status' => OrderEnumStatus::OFD->value,
                    'order_id' => $id,
                ]);
                return 'Order is out for delivery.';
            }elseif(!$this->checkOrderStatus($order_status, OrderEnumStatus::DELIVERED)){
                OrderStatus::create([
                    'status' => OrderEnumStatus::DELIVERED->value,
                    'order_id' => $id,
                ]);
                return 'Order delivered successfully.';
                }
            return 'Order already delivered successfully.';
        }
    }

    public function collectCodOrderPayment(string $id): string
    {
        $order_status = OrderStatus::where('order_id', $id)->orderBy('id', 'DESC')->get();
        if($this->checkOrderStatus($order_status, OrderEnumStatus::CANCELLED)){
            return 'Order is cancelled already!';
        }else{
            OrderPayment::updateOrCreate(
                ['order_id' => $id],
                [
                    'status' => PaymentStatus::PAID->value,
                ]
            );
            return 'Payment paid successfully.';
        }
    }

    public function cancelOrder(string $id, Order $order): string
    {
        $order_status = OrderStatus::where('order_id', $id)->orderBy('id', 'DESC')->get();
        if($this->checkOrderStatus($order_status, OrderEnumStatus::CANCELLED)){
            return 'Order is cancelled already!';
        }else{
            DB::beginTransaction();
            try {
                //code...
                if($order->payment->mode==PaymentMode::RAZORPAY){
                    (new RazorpayService)->refund($order->total_price, $order->payment->razorpay_payment_id);
                }else if($order->payment->mode==PaymentMode::PHONEPE){
                    (new PhonepeService)->refund(json_decode($order->payment->payment_data)->transactionId, $order->id, $order->user_id, $order->total_price);
                }else if($order->payment->mode==PaymentMode::PAYU){
                    (new PayUService)->refund($order);
                }else if($order->payment->mode==PaymentMode::CASHFREE){
                    (new CashfreeService)->refund($order);
                }
                OrderStatus::create([
                    'status' => OrderEnumStatus::CANCELLED->value,
                    'order_id' => $id,
                ]);
                OrderPayment::updateOrCreate(
                    ['order_id' => $id],
                    [
                        'status' => PaymentStatus::REFUND->value,
                    ]
                );
                return 'Order cancelled successfully.';
            } catch (\Throwable $th) {
                DB::rollBack();
                return $th->getMessage();
            } finally {
                DB::commit();
            }
        }
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
            ->orWhereHas('products', function($q) use($value) {
                $q->where('name', 'LIKE', '%' . $value . '%');
            });
        });
    }
}