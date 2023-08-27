<?php

namespace App\Modules\Coupon\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Cart\Resources\CartCollection;
use App\Modules\Cart\Services\CartAmountService;
use App\Modules\Cart\Services\CartService;
use App\Modules\Charge\Resources\UserChargeCollection;
use App\Modules\Coupon\Resources\CouponCollection;
use App\Modules\Coupon\Services\AppliedCouponService;
use App\Modules\Tax\Resources\TaxCollection;

class RemoveCouponController extends Controller
{
    private $appliedCouponService;

    public function __construct(AppliedCouponService $appliedCouponService)
    {
        $this->appliedCouponService = $appliedCouponService;
    }

    public function delete(){

        try {
            //code...
            $this->appliedCouponService->remove();
            return response()->json([
                "message" => "Coupon removed successfully.",
                'cart' => CartCollection::collection((new CartService)->all()),
                'cart_subtotal' => (new CartAmountService())->get_subtotal(),
                'tax' => TaxCollection::make((new CartAmountService())->get_tax()),
                'total_tax' => (new CartAmountService())->get_tax_price(),
                'cart_charges' => UserChargeCollection::collection((new CartAmountService())->get_all_charges()),
                'total_charges' => (new CartAmountService())->get_charge_price(),
                "coupon_applied" => !empty($this->appliedCouponService->getCouponApplied()) ? CouponCollection::make($this->appliedCouponService->getCouponApplied()->coupon) : null,
                'discount_price' => (new CartAmountService())->get_discount_price(),
                'total_price' => (new CartAmountService())->get_total_price(),
            ], 200);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Something went wrong. Please try again"], 400);
        }

    }
}
