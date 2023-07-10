<?php

namespace App\Modules\Authentication\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Services\RateLimitService;
use App\Modules\Authentication\Requests\ProfilePostRequest;
use App\Modules\Authentication\Services\AuthService;
use App\Modules\User\Services\UserService;

class ProfileController extends Controller
{
    private $authService;
    private $userService;

    public function __construct(AuthService $authService, UserService $userService)
    {
        $this->authService = $authService;
        $this->userService = $userService;
    }

    public function get(){
        return view('admin.pages.profile.index');
    }

    public function post(ProfilePostRequest $request){

        try {
            //code...
            $user = $this->authService->authenticated_user();
            $this->userService->update(
                $request->validated(),
                $user
            );
            (new RateLimitService($request))->clearRateLimit();
            return response()->json(["message" => "Profile Updated successfully."], 201);
        } catch (\Throwable $th) {
            return response()->json(["error"=>"something went wrong. Please try again"], 400);
        }

    }
}
