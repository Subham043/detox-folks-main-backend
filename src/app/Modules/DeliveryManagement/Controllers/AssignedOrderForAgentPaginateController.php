<?php

namespace App\Modules\DeliveryManagement\Controllers;

use App\Enums\OrderEnumStatus;
use App\Enums\PaymentMode;
use App\Enums\PaymentStatus;
use App\Http\Controllers\Controller;
use App\Http\Services\SmsService;
use App\Modules\DeliveryManagement\Requests\DeliverOrderRequest;
use App\Modules\DeliveryManagement\Services\DeliveryManagementService;
use App\Modules\Order\Models\OrderPayment;
use App\Modules\Order\Models\OrderStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Collection;

class AssignedOrderForAgentPaginateController extends Controller
{
    private $service;

    public function __construct(DeliveryManagementService $service)
    {
        $this->service = $service;
    }

    public function get(Request $request){
        $order = $this->service->paginateOrderAssigend(auth()->user()->id, $request->total ?? 10);
        return view('admin.pages.delivery_management.order.index', compact(['order']))
        ->with('search', $request->query('filter')['search'] ?? '')
        ->with('payment_status', $request->query('filter')['has_payment_status'] ?? 'all')
        ->with('payment_mode', $request->query('filter')['has_payment_mode'] ?? 'all')
        ->with('order_status', $request->query('filter')['has_status'] ?? 'all')
        ->with('has_date', explode(' - ', ($request->query('filter')['has_date']) ?? ''))
        ->with('order_count', $this->service->orderCount(auth()->user()->id) ?? 0)
        ->with('earning_count', $this->service->earningCount(auth()->user()->id) ?? 0)
        ->with('loss_count', $this->service->lossCount(auth()->user()->id) ?? 0)
        ->with([
            'order_statuses' => Arr::map(OrderEnumStatus::cases(), fn($enum) => $enum->value),
            'payment_statuses' => Arr::map(PaymentStatus::cases(), fn($enum) => $enum->value),
            'payment_modes' => Arr::map(PaymentMode::cases(), fn($enum) => $enum->value),
        ]);
    }

    public function detail(string $order_id){
        $order = $this->service->getOrderAssigendById(auth()->user()->id, $order_id);
        return view('admin.pages.delivery_management.order.detail', compact(['order']))->with([
            'order_statuses' => $order->statuses->pluck('status')->toArray(),
        ]);
    }

    public function send_otp(string $order_id){
        $order = $this->service->getOrderAssigendById(auth()->user()->id, $order_id);
        $order->otp = random_int(1000, 9999);
        $order->save();
        (new SmsService)->sendDeliveryConfirmation($order->phone, $order->otp);
        return response()->json(["message" => "OTP sent successfully"], 200);
    }

    public function deliver_order(DeliverOrderRequest $request, string $order_id){
        $request->validated();
        $order = $this->service->getOrderAssigendById(auth()->user()->id, $order_id);
        $order_status = OrderStatus::where('order_id', $order_id)->orderBy('id', 'DESC')->get();
        if($this->checkOrderStatus($order_status, OrderEnumStatus::CANCELLED)){
            return response()->json(["message" => "Order is cancelled already"], 400);
        }
        if($order->current_status->status==OrderEnumStatus::OFD->value){
            return response()->json(["message" => "Order is not out for delivery"], 400);
        }
        if($order->otp==$request->otp){
            $order->otp = random_int(1000, 9999);
            $order->save();
            OrderPayment::updateOrCreate(
                ['order_id' => $order_id],
                [
                    'status' => PaymentStatus::PAID->value,
                ]
            );
            OrderStatus::create([
                'status' => OrderEnumStatus::DELIVERED->value,
                'order_id' => $order_id,
            ]);
            return response()->json(["message" => "Order delivered successfully"], 200);
        }
        return response()->json(["message" => "Invalid OTP"], 400);
    }

    private function checkOrderStatus(Collection $order_status, OrderEnumStatus $status): bool
    {
        return in_array($status, $order_status->pluck('status')->toArray());
    }
}