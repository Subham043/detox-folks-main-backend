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
            $data = $request->validated();
            if($user->email != $data['email']){
                $data['email_verified_at'] = null;
            }
            if($user->phone != $data['phone']){
                $data['phone_verified_at'] = null;
            }
            $this->userService->update(
                $data,
                $user
            );
            $user->save();
            (new RateLimitService($request))->clearRateLimit();
            return response()->json(["message" => "Profile Updated successfully."], 201);
        } catch (\Throwable $th) {
            return response()->json(["error"=>"something went wrong. Please try again"], 400);
        }

    }
}