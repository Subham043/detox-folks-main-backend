<?php

namespace App\Modules\Coupon\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Coupon\Requests\CouponCreateRequest;
use App\Modules\Coupon\Services\CouponService;

class CouponCreateController extends Controller
{
    private $couponService;

    public function __construct(CouponService $couponService)
    {
        $this->middleware('permission:create coupon', ['only' => ['get','post']]);
        $this->couponService = $couponService;
    }

    public function get(){
        return view('admin.pages.coupon.create');
    }

    public function post(CouponCreateRequest $request){

        try {
            //code...
            $coupon = $this->couponService->create(
                $request->except('image')
            );
            return response()->json(["message" => "Coupon created successfully."], 201);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Something went wrong. Please try again"], 400);
        }

    }
}
