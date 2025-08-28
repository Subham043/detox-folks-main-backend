<?php

namespace App\Modules\Authentication\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Services\RateLimitService;
use App\Modules\Authentication\Requests\UserRegisterPostRequest;
use App\Modules\Authentication\Resources\AuthCollection;
use App\Modules\Authentication\Services\AuthService;
use App\Modules\User\Services\UserService;
use Illuminate\Auth\Events\Registered;

class UserRegisterController extends Controller
{
    private UserService $userService;
    private $authService;

    public function __construct(UserService $userService, AuthService $authService)
    {
        $this->userService = $userService;
        $this->authService = $authService;
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
        }
        return response()->json([
            'message' => 'Oops! something went wrong, please try again!',
        ], 400);
    }
}
