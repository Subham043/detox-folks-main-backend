<?php

namespace App\Modules\DeliveryManagement\Controllers;

use App\Enums\OrderEnumStatus;
use App\Enums\PaymentMode;
use App\Enums\PaymentStatus;
use App\Http\Controllers\Controller;
use App\Http\Services\PayUService;
use App\Http\Services\SmsService;
use App\Modules\Authentication\Models\User;
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

    public function payUMoneyView(string $order_id)
    {
        $order = $this->service->getOrderPlacedByIdPaymentPendingVia(auth()->user()->id, $order_id);
        $order_status = OrderStatus::where('order_id', $order_id)->orderBy('id', 'DESC')->get();
        if($this->checkOrderStatus($order_status, OrderEnumStatus::CANCELLED)){
            return redirect(route('delivery_management.agent.order_detail.get', $order_id))->with('error_status', "Order is cancelled already");
        }
        if($order->current_status->status==OrderEnumStatus::OFD->value){
            return redirect(route('delivery_management.agent.order_detail.get', $order_id))->with('error_status', "Order is not out for delivery");
        }
        if($order->payment && $order->payment->status == PaymentStatus::PAID){
            return redirect(route('delivery_management.agent.order_detail.get', $order_id))->with('error_status', "Order is already paid");
        }

        $successURL = route('pay.u.upi.success', ['order_id' => $order->id, 'delivery_agent_id' => auth()->user()->id]);
        $failURL = route('pay.u.upi.fail', ['order_id' => $order->id, 'delivery_agent_id' => auth()->user()->id]);
        $data = (new PayUService)->create_upi_order($order, $successURL, $failURL);

        return view('payu.upi')->with([
            'action' => $data['action'],
            'hash' => $data['hash'],
            'MERCHANT_KEY' => $data['MERCHANT_KEY'],
            'txnid' => $data['txnid'],
            'successURL' => $data['successURL'],
            'failURL' => $data['failURL'],
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            // 'qrId' => $data['qrId'],
            'amount' => $data['amount']
        ]);
    }

    public function payUResponse($order_id, $delivery_agent_id, Request $request)
    {
        $order = $this->service->getOrderPlacedByIdPaymentPendingVia($delivery_agent_id, $order_id);

        $rData = (new PayUService)->get_order((string) $order->id);
        if($rData->status == 1){
            OrderPayment::updateOrCreate(
                ['order_id' => $order_id],
                [
                    'mode' => PaymentMode::PAYU->value,
                    'status' => PaymentStatus::PAID->value,
                    'payment_data' => json_encode($request->all()),
                ]
            );
            if(auth()->check()==false){
                $user = User::where('id', $delivery_agent_id)->first();
                if($user){
                    auth()->login($user);
                }
            }
            return redirect(route('delivery_management.agent.order_detail.get', $order_id))->with('success_status', "Payment completed successfully");
        }
        if(auth()->check()==false){
            $user = User::where('id', $delivery_agent_id)->first();
            if($user){
                auth()->login($user);
            }
        }
        return redirect(route('delivery_management.agent.order_detail.get', $order_id))->with('error_status', "Payment failed");
    }

    public function payUCancel($order_id, $delivery_agent_id, Request $request)
    {
        $order = $this->service->getOrderPlacedByIdPaymentPendingVia($delivery_agent_id, $order_id);
        if(auth()->check()==false){
            $user = User::where('id', $delivery_agent_id)->first();
            if($user){
                auth()->login($user);
            }
        }
        return redirect(route('delivery_management.agent.order_detail.get', $order_id))->with('error_status', "Payment failed");
    }
}
