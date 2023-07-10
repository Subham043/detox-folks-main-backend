<?php

namespace App\Modules\Authentication\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Services\RateLimitService;
use App\Modules\Authentication\Requests\ForgotPasswordPostRequest;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{

    public function get(){
        return view('admin.pages.auth.forgotpassword');
    }

    public function post(ForgotPasswordPostRequest $request){

        $status = Password::sendResetLink(
            $request->only('email')
        );
        if($status === Password::RESET_LINK_SENT){
            (new RateLimitService($request))->clearRateLimit();
            return redirect(route('forgot_password.get'))->with(['success_status' => __($status)]);
        }
        return redirect(route('forgot_password.get'))->with(['error_status' => __($status)]);

    }
}
