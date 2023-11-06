<?php

namespace App\Modules\Authentication\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Services\RateLimitService;
use App\Modules\Authentication\Requests\UserProfilePostRequest;
use App\Modules\Authentication\Resources\AuthCollection;
use App\Modules\Authentication\Services\AuthService;
use App\Modules\User\Services\UserService;

class UserProfileController extends Controller
{
    private $authService;
    private $userService;

    public function __construct(AuthService $authService, UserService $userService)
    {
        $this->authService = $authService;
        $this->userService = $userService;
    }

    public function get(){
        return response()->json([
            'user' => AuthCollection::make(auth()->user()),
        ], 200);
    }

    public function post(UserProfilePostRequest $request){

        $email_status = false;
        try {
            //code...
            $user = $this->authService->authenticated_user();
            if($user->email != $request->email) {
                $email_status = true;
            }
            $updated_user = $this->userService->update(
                $request->validated(),
                $user
            );
            // if ($email_status) {
            //     $updated_user->email_verified_at = null;
            //     $updated_user->save();
            //     $updated_user->sendEmailVerificationNotification();
            // }

            (new RateLimitService($request))->clearRateLimit();
            return response()->json([
                'message' => "Profile Updated successfully.",
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => "something went wrong. Please try again.",
            ], 400);
        }

    }
}
