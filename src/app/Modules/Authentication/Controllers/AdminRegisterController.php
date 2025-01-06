<?php

namespace App\Modules\Authentication\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Authentication\Requests\AdminRegisterPostRequest;
use App\Modules\User\Services\UserService;
use Spatie\Permission\Models\Role;

class AdminRegisterController extends Controller
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function get(){
        $roles = Role::whereIn('name', ['App Promoter', 'Reward Riders', 'Referral Rockstars'])->get();
        return view('admin.pages.auth.register')->with('roles', $roles);
    }

    public function post(AdminRegisterPostRequest $request){

        try {
            //code...
            $user = $this->userService->create(
                [
                    ...$request->except('role'),
                    'email' =>  !empty($request->email) ? $request->email : null
                ]
            );
            $this->userService->syncRoles([$request->role], $user);
            if($user->email){
                $user->sendEmailVerificationNotification();
            }
            return redirect()->intended(route('login_otp.get'))->with('success_status', 'Registration completed successfully.');
        } catch (\Throwable $th) {
            return redirect()->intended(route('register.get'))->with('error_status', 'Something went wrong. Please try again');
        }
    }
}
