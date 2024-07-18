<?php

namespace App\Modules\Dashboard\Controllers;

use App\Enums\OrderEnumStatus;
use App\Enums\PaymentStatus;
use App\Http\Controllers\Controller;
use App\Modules\Dashboard\Services\DashboardService;
use App\Modules\Order\Models\Order;
use App\Modules\Order\Models\OrderStatus;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    private $dashboardService;

    public function __construct(DashboardService $dashboardService)
    {
        $this->dashboardService = $dashboardService;
    }

    public function get(Request $request){
        $health = $this->dashboardService->getAppHealthResult($request);
        $lastRanAt  = new Carbon($health?->finishedAt);
        return view('admin.pages.dashboard.index', compact(['health', 'lastRanAt']))->with(([
            'total_orders' => Order::count(),
            'total_cancelled_orders' => Order::whereHas('current_status', function($q) {
                $q->where('status', OrderEnumStatus::CANCELLED);
            })->count(),
            'total_confirmed_orders' => Order::whereHas('current_status', function($q) {
                $q->where('status', OrderEnumStatus::CONFIRMED);
            })->count(),
            'total_delivered_orders' => Order::whereHas('current_status', function($q) {
                $q->where('status', OrderEnumStatus::DELIVERED);
            })->count(),
            'total_ofd_orders' => Order::whereHas('current_status', function($q) {
                $q->where('status', OrderEnumStatus::OFD);
            })->count(),
            'total_packed_orders' => Order::whereHas('current_status', function($q) {
                $q->where('status', OrderEnumStatus::PACKED);
            })->count(),
            'total_payment_pending' => Order::whereHas('payment', function($q){
                $q->where('status', PaymentStatus::PENDING);
            })->sum('total_price'),
            'total_payment_paid' => Order::whereHas('payment', function($q){
                $q->where('status', PaymentStatus::PAID);
            })->sum('total_price'),
            'total_payment_refund' => Order::whereHas('payment', function($q){
                $q->where('status', PaymentStatus::REFUND);
            })->sum('total_price'),
        ]));
    }
}