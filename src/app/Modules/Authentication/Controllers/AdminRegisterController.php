<?php

namespace App\Modules\Authentication\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Authentication\Requests\AdminRegisterPostRequest;
use App\Modules\Promoter\Models\Promoter;
use App\Modules\Promoter\Models\PromoterCode;
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
                    ...$request->except(['role', 'code']),
                    'email' =>  !empty($request->email) ? $request->email : null
                ]
            );
            $this->userService->syncRoles([$request->role], $user);
            if($request->code){
                $app_promoter_codes = PromoterCode::with(['promoter'])->where('code', $request->code)->first();
                $promoter = Promoter::where('installed_by_id', $user->id)->first();
                if(!$promoter && $app_promoter_codes){
                    Promoter::create([
                        'installed_by_id' => $user->id,
                        'promoted_by_id' => $app_promoter_codes->promoter->id
                    ]);
                }
            }
            if($user->email){
                $user->sendEmailVerificationNotification();
            }
            return redirect()->intended(route('login_otp.get'))->with('success_status', 'Registration completed successfully.');
        } catch (\Throwable $th) {
            return redirect()->intended(route('register.get'))->with('error_status', 'Something went wrong. Please try again');
        }
    }
}
