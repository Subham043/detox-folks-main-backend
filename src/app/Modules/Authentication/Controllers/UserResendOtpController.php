<?php

namespace App\Modules\Authentication\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Services\RateLimitService;
use App\Http\Services\SmsService;
use App\Modules\Authentication\Requests\UserResendOtpPostRequest;
use App\Modules\User\Services\UserService;

class UserResendOtpController extends Controller
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function post(UserResendOtpPostRequest $request){
        // $is_success = (new SmsService)->send($request->phone, 'Your OTP is 1234');
        $is_success = true;
        if($is_success){
            (new RateLimitService($request))->clearRateLimit();
            return response()->json([
                'message' => 'OTP sent successfully.',
                'test' => $is_success
            ], 200);
        }
        return response()->json([
            'message' => 'Oops! something went wrong, please try again!',
        ], 400);
    }
}