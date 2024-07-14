<?php

namespace App\Modules\Role\Services;

use Spatie\Permission\Models\Role;
use Illuminate\Database\Eloquent\Collection;

class RoleService
{

    public function all(): Collection
    {
        return Role::all();
    }

}