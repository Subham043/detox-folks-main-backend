<?php

namespace App\Modules\Promoter\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Promoter\Services\PromoterService;
use Illuminate\Http\Request;

class PromoterPaginateController extends Controller
{
    private $service;

    public function __construct(PromoterService $service)
    {
        $this->service = $service;
    }

    public function get(Request $request){
        $data = $this->service->paginatePromoter($request->total ?? 10);
        $users = $data->through(function ($user) {
            $no_of_orders = 0;
            $orders_count = $user->app_installer->pluck('orders_count')->toArray();
            foreach ($orders_count as $key => $value) {
                if($value > 0){
                    $no_of_orders++;
                }
            }
            $user->no_of_orders = $no_of_orders;
            return $user;
        });
        return view('admin.pages.promoter.agent.paginate')
            ->with('data', $users)
            ->with('search', $request->query('filter')['search'] ?? '');
    }

}
