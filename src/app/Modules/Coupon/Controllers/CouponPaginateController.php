<?php

namespace App\Modules\Coupon\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Coupon\Services\CouponService;
use Illuminate\Http\Request;

class CouponPaginateController extends Controller
{
    private $couponService;

    public function __construct(CouponService $couponService)
    {
        $this->middleware('permission:list coupon', ['only' => ['get']]);
        $this->couponService = $couponService;
    }

    public function get(Request $request){
        $data = $this->couponService->paginate($request->total ?? 10);
        return view('admin.pages.coupon.paginate', compact(['data']))
            ->with('search', $request->query('filter')['search'] ?? '');
    }

}
