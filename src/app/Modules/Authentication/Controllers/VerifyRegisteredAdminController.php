<?php

namespace App\Modules\Authentication\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class VerifyRegisteredAdminController extends Controller
{

    public function resend_notification(Request $request){
        if($request->user()->hasVerifiedEmail()){
            return redirect()->back()->with('error_status', 'Oops! you are already a verified user.');
        }
        $request->user()->sendEmailVerificationNotification();
        return redirect()->back()->with('success_status', 'Verification link sent to your registered email.');
    }


}