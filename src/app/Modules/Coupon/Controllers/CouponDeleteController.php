<?php

namespace App\Modules\Coupon\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Coupon\Services\CouponService;

class CouponDeleteController extends Controller
{
    private $couponService;

    public function __construct(CouponService $couponService)
    {
        $this->middleware('permission:delete coupon', ['only' => ['get']]);
        $this->couponService = $couponService;
    }

    public function get($id){
        $coupon = $this->couponService->getById($id);

        try {
            //code...
            $this->couponService->delete(
                $coupon
            );
            return redirect()->back()->with('success_status', 'Coupon deleted successfully.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error_status', 'Something went wrong. Please try again');
        }
    }

}
