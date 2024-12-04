<?php

namespace App\Modules\Authentication\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Services\RateLimitService;
use App\Http\Services\SmsService;
use App\Modules\Authentication\Requests\LoginOtpPostRequest;
use App\Modules\Authentication\Requests\LoginPostRequest;
use App\Modules\Authentication\Requests\PhonePostRequest;
use App\Modules\Authentication\Services\AuthService;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    private $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function get(){
        return view('admin.pages.auth.login');
    }

    public function login_otp(){
        return view('admin.pages.auth.login_otp');
    }

    public function post(LoginPostRequest $request){

        $is_authenticated = $this->authService->login($request->validated());

        if ($is_authenticated) {
            (new RateLimitService($request))->clearRateLimit();
            return redirect()->intended(route('dashboard.get'))->with('success_status', 'Logged in successfully.');
        }

        return redirect(route('login_email.get'))->with('error_status', 'Oops! You have entered invalid credentials');
    }

    public function send_otp(PhonePostRequest $request){
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

    public function otp_post(LoginOtpPostRequest $request){

        $request->validated();
        $user = $this->authService->getByPhone($request->phone);

        if ($user && $user->otp == $request->otp) {
            $user->otp = random_int(1000, 9999);
            $user->save();
            Auth::login($user);
            (new RateLimitService($request))->clearRateLimit();
            return redirect()->intended(route('dashboard.get'))->with('success_status', 'Logged in successfully.');
        }

        return redirect(route('login_otp.get'))->with('error_status', 'Oops! You have entered invalid credentials');
    }
}
