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
        $roles = Role::whereIn('name', ['Delivery Agent', 'App Promoter'])->get();
        return view('admin.pages.auth.register')->with('roles', $roles);
    }

    public function post(AdminRegisterPostRequest $request){

        try {
            //code...
            $user = $this->userService->create(
                $request->except('role')
            );
            $this->userService->syncRoles([$request->role], $user);
            $user->sendEmailVerificationNotification();
            return redirect()->intended(route('login.get'))->with('success_status', 'Registration completed successfully.');
        } catch (\Throwable $th) {
            return redirect()->intended(route('register.get'))->with('error_status', 'Something went wrong. Please try again');
        }
    }
}