<?php

namespace App\Modules\Dashboard\Controllers;

use App\Enums\OrderEnumStatus;
use App\Enums\PaymentStatus;
use App\Http\Controllers\Controller;
use App\Modules\Authentication\Models\User;
use App\Modules\Blog\Models\Blog;
use App\Modules\Category\Models\Category;
use App\Modules\Dashboard\Services\DashboardService;
use App\Modules\Enquiry\ContactForm\Models\ContactForm;
use App\Modules\Enquiry\OrderForm\Models\OrderForm;
use App\Modules\Legal\Models\Legal;
use App\Modules\Order\Models\Order;
use App\Modules\Order\Models\OrderStatus;
use App\Modules\Product\Models\Product;
use App\Modules\Promoter\Models\Promoter;
use App\Modules\SubCategory\Models\SubCategory;
use App\Modules\Testimonial\Models\Testimonial;
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
            'total_products' => Product::where('is_draft', true)->count(),
            'admin_users' => User::whereHas('roles', function($q) { $q->whereIn('name', ['Super-Admin']); })->count(),
            'staff_users' => User::whereHas('roles', function($q) { $q->whereIn('name', ['Staff']); })->count(),
            'content_manager_users' => User::whereHas('roles', function($q) { $q->whereIn('name', ['Content Manager']); })->count(),
            'inventory_manager_users' => User::whereHas('roles', function($q) { $q->whereIn('name', ['Inventory Manager']); })->count(),
            'warehouse_manager_users' => User::whereHas('roles', function($q) { $q->whereIn('name', ['Warehouse Manager']); })->count(),
            'delivery_agent_users' => User::whereHas('roles', function($q) { $q->whereIn('name', ['Delivery Agent']); })->count(),
            'reward_rider_users' => User::whereHas('roles', function($q) { $q->whereIn('name', ['Reward Riders']); })->count(),
            'referral_rockstar_users' => User::whereHas('roles', function($q) { $q->whereIn('name', ['Referral Rockstars']); })->count(),
            'normal_users' => User::whereHas('roles', function($q) { $q->whereIn('name', ['User']); })->count(),
            'contact_enquiry' => ContactForm::count(),
            'order_enquiry' => OrderForm::count(),
            'installer' => Promoter::where('promoted_by_id', auth()->user()->id)->count(),
            'testimonials' => Testimonial::where('is_draft', true)->count(),
            'legal_pages' => Legal::where('is_draft', true)->count(),
            'categories' => Category::where('is_draft', true)->count(),
            'sub_categories' => SubCategory::where('is_draft', true)->count(),
        ]));
    }
}
