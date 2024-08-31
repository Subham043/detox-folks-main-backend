<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Spatie\Permission\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        //permission for roles
        Role::create(['name' => 'Staff']);
        Role::create(['name' => 'Content Manager']);
        Role::create(['name' => 'Inventory Manager']);
        Role::create(['name' => 'Warehouse Manager']);
        Role::create(['name' => 'Delivery Agent']);
        Role::create(['name' => 'User']);

    }
}
