<?php

namespace App\Modules\Coupon\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Coupon\Requests\CouponUpdateRequest;
use App\Modules\Coupon\Services\CouponService;

class CouponUpdateController extends Controller
{
    private $couponService;

    public function __construct(CouponService $couponService)
    {
        $this->middleware('permission:edit coupon', ['only' => ['get','post']]);
        $this->couponService = $couponService;
    }

    public function get($id){
        $data = $this->couponService->getById($id);
        return view('admin.pages.coupon.update', compact('data'));
    }

    public function post(CouponUpdateRequest $request, $id){
        $coupon = $this->couponService->getById($id);
        try {
            //code...
            $this->couponService->update(
                $request->except('image'),
                $coupon
            );
            return response()->json(["message" => "Coupon updated successfully."], 201);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Something went wrong. Please try again"], 400);
        }

    }
}
