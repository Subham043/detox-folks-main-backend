<?php

namespace App\Modules\User\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Role\Services\RoleService;
use App\Modules\User\Services\UserService;
use Illuminate\Http\Request;

class UserPaginateController extends Controller
{
    private $userService;
    private $roleService;

    public function __construct(UserService $userService, RoleService $roleService)
    {
        $this->userService = $userService;
        $this->roleService = $roleService;
    }

    public function get(Request $request){
        $data = $this->userService->paginate($request->total ?? 10);
        $roles = $this->roleService->all()->pluck('name')->toArray();
        return view('admin.pages.user.paginate', compact(['data', 'roles']))
            ->with('search', $request->query('filter')['search'] ?? '')
            ->with('has_role', $request->query('filter')['has_role'] ?? 'all');
    }

}
