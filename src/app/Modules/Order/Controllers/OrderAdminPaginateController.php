<?php

namespace App\Modules\Order\Controllers;

use App\Enums\OrderEnumStatus;
use App\Enums\PaymentMode;
use App\Enums\PaymentStatus;
use App\Http\Controllers\Controller;
use App\Modules\Order\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class OrderAdminPaginateController extends Controller
{
    private $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function get(Request $request){
        $data = $this->orderService->paginateForAdmin($request->total ?? 10);
        return view('admin.pages.order.paginate', compact(['data']))
            ->with('search', $request->query('filter')['search'] ?? '')
            ->with('payment_status', $request->query('filter')['has_payment_status'] ?? 'all')
            ->with('payment_mode', $request->query('filter')['has_payment_mode'] ?? 'all')
            ->with('order_status', $request->query('filter')['has_status'] ?? 'all')
            ->with('has_date', explode(' - ', ($request->query('filter')['has_date']) ?? ''))
            ->with('order_count', $this->orderService->orderCountAdmin() ?? 0)
            ->with('earning_count', $this->orderService->earningCountAdmin() ?? 0)
            ->with('loss_count', $this->orderService->lossCountAdmin() ?? 0)
            ->with([
                'order_statuses' => Arr::map(OrderEnumStatus::cases(), fn($enum) => $enum->value),
                'payment_statuses' => Arr::map(PaymentStatus::cases(), fn($enum) => $enum->value),
                'payment_modes' => Arr::map(PaymentMode::cases(), fn($enum) => $enum->value),
            ]);
    }

}