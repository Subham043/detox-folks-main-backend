<?php

namespace App\Modules\Coupon\Services;

use App\Modules\Coupon\Models\AppliedCoupon;
use App\Modules\Coupon\Models\Coupon;
use Illuminate\Database\Eloquent\Collection;

class AppliedCouponService
{

    public function all(): Collection
    {
        return AppliedCoupon::where('user_id', auth()->user()->id)->get();
    }

    public function getById(Int $id): AppliedCoupon|null
    {
        return AppliedCoupon::where('user_id', auth()->user()->id)->findOrFail($id);
    }


    public function getByCode(String $code): AppliedCoupon|null
    {
        return AppliedCoupon::where('user_id', auth()->user()->id)->where('code', $code)->firstOrFail();
    }

    public function getCouponApplied(): AppliedCoupon|null
    {
        return AppliedCoupon::where('user_id', auth()->user()->id)->first();
    }

    public function apply(string $coupon_code): AppliedCoupon
    {
        $coupon = Coupon::where('code', $coupon_code)->firstOrFail();
        $applied_coupon = AppliedCoupon::updateOrCreate(
            ['user_id'=>auth()->user()->id],
            ['coupon_id' => $coupon->id]
        );
        return $applied_coupon;
    }

    public function remove(): bool|null
    {
        return AppliedCoupon::where('user_id', auth()->user()->id)->delete();
    }

}
