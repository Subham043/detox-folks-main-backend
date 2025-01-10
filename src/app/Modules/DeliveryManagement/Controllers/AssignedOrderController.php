<?php

namespace App\Modules\DeliveryManagement\Controllers;

use App\Enums\OrderEnumStatus;
use App\Enums\PaymentMode;
use App\Enums\PaymentStatus;
use App\Http\Controllers\Controller;
use App\Modules\DeliveryManagement\Requests\UnassignDeliveryAgentRequest;
use App\Modules\DeliveryManagement\Services\DeliveryManagementService;
use App\Modules\Order\Exports\OrderExport;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Maatwebsite\Excel\Facades\Excel;

class AssignedOrderController extends Controller
{
    private $service;

    public function __construct(DeliveryManagementService $service)
    {
        $this->service = $service;
    }

    public function get(Request $request, $user_id){
        $agent = $this->service->getDeliveryAgentById($user_id);
        $order = $this->service->paginateOrderAssigend($user_id, $request->total ?? 10);
        return view('admin.pages.delivery_management.agent.assigned_order', compact(['agent', 'order', 'user_id']))
        ->with('search', $request->query('filter')['search'] ?? '')
        ->with('payment_status', $request->query('filter')['has_payment_status'] ?? 'all')
        ->with('payment_mode', $request->query('filter')['has_payment_mode'] ?? 'all')
        ->with('order_status', $request->query('filter')['has_status'] ?? 'all')
        ->with('has_date', explode(' - ', ($request->query('filter')['has_date']) ?? ''))
        ->with('order_count', $this->service->orderCount($user_id) ?? 0)
        ->with('earning_count', $this->service->earningCount($user_id) ?? 0)
        ->with('loss_count', $this->service->lossCount($user_id) ?? 0)
        ->with([
            'order_statuses' => Arr::map(OrderEnumStatus::cases(), fn($enum) => $enum->value),
            'payment_statuses' => Arr::map(PaymentStatus::cases(), fn($enum) => $enum->value),
            'payment_modes' => Arr::map(PaymentMode::cases(), fn($enum) => $enum->value),
        ]);
    }

    public function export(Request $request, $user_id){
        $this->service->getDeliveryAgentById($user_id);
        $order = $this->service->exportOrderAssigend($user_id, $request->total ?? 10);
        return Excel::download(new OrderExport($order), 'orders_assigned.xlsx');
    }

    public function post(UnassignDeliveryAgentRequest $request, $user_id){
        $agent = $this->service->getDeliveryAgentById($user_id);
        try {
            //code...
            if($request->orders && count($request->orders)>0){
                $this->service->unassign_orders($agent, $request->orders);
            }
            return response()->json(["message" => "Agent unassigned successfully."], 201);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Something went wrong. Please try again"], 400);
        }

    }
}
