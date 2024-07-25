<?php

namespace App\Modules\Authentication\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Services\RateLimitService;
use App\Http\Services\SmsService;
use App\Modules\Authentication\Requests\UserLoginOtpPostRequest;
use App\Modules\Authentication\Requests\UserLoginPostRequest;
use App\Modules\Authentication\Requests\UserPhonePostRequest;
use App\Modules\Authentication\Resources\AuthCollection;
use App\Modules\Authentication\Services\AuthService;
use Illuminate\Support\Facades\Auth;

class UserLoginController extends Controller
{
    private $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function post(UserLoginPostRequest $request){

        $is_authenticated = $this->authService->user_login($request->validated());

        if ($is_authenticated) {
            (new RateLimitService($request))->clearRateLimit();
            $token = $this->authService->generate_token(auth()->user());
            return response()->json([
                'message' => 'Logged in successfully.',
                'token_type' => 'Bearer',
                'token' => $token,
                'user' => AuthCollection::make(auth()->user()),
            ], 200);
        }
        return response()->json([
            'message' => 'Oops! You have entered invalid credentials',
        ], 400);
    }

    public function phone_otp_post(UserPhonePostRequest $request){
        $request->validated();
        $user = $this->authService->getByPhone($request->phone);
        if ($user) {
            $user->otp = random_int(1000, 9999);
            $user->save();
            (new SmsService)->sendLoginOtp($user->phone, $user->otp);
            (new RateLimitService($request))->clearRateLimit();
        }
        return response()->json(["message" => "OTP sent successfully"], 200);
    }

    public function phone_post(UserLoginOtpPostRequest $request){

        $request->validated();
        $user = $this->authService->getByPhone($request->phone);

        if ($user && $user->otp == $request->otp) {
            $user->otp = random_int(1000, 9999);
            $user->save();
            Auth::login($user);
            $token = $this->authService->generate_token($user);
            (new RateLimitService($request))->clearRateLimit();
            return response()->json([
                'message' => 'Logged in successfully.',
                'token_type' => 'Bearer',
                'token' => $token,
                'user' => AuthCollection::make(auth()->user()),
            ], 200);
        }

        return response()->json([
            'message' => 'Oops! You have entered invalid credentials',
        ], 400);
    }
}