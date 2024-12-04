<?php

namespace App\Modules\Authentication\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Services\RateLimitService;
use App\Modules\Authentication\Requests\UserRegisterPostRequest;
use App\Modules\Authentication\Resources\AuthCollection;
use App\Modules\User\Services\UserService;
use Illuminate\Auth\Events\Registered;

class UserRegisterController extends Controller
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function post(UserRegisterPostRequest $request){

        $user = $this->userService->create([
            ...$request->validated(),
            'email' => !empty($request->email) ? $request->email : null
        ]);
        $this->userService->syncRoles(['User'], $user);
        if($user->email){
            event(new Registered($user));
        }

        if ($user) {
            (new RateLimitService($request))->clearRateLimit();
            return response()->json([
                'message' => 'Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.',
                'user' => AuthCollection::make($user),
            ], 201);
        }
        return response()->json([
            'message' => 'Oops! something went wrong, please try again!',
        ], 400);
    }
}
