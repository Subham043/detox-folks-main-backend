<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Spatie\Permission\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        //permission for roles
        Permission::create(['name' => 'edit roles']);
        Permission::create(['name' => 'delete roles']);
        Permission::create(['name' => 'create roles']);
        Permission::create(['name' => 'list roles']);

        //permission for users
        Permission::create(['name' => 'edit users']);
        Permission::create(['name' => 'delete users']);
        Permission::create(['name' => 'create users']);
        Permission::create(['name' => 'list users']);

        //permission for enquiries
        Permission::create(['name' => 'delete enquiries']);
        Permission::create(['name' => 'list enquiries']);

        //permission for logs and dashboard
        Permission::create(['name' => 'view application error logs']);
        Permission::create(['name' => 'view application analytics on dashboard']);
        Permission::create(['name' => 'list activity logs']);
        Permission::create(['name' => 'view activity log detail']);

        //permission for legal pages
        Permission::create(['name' => 'edit legal pages']);
        Permission::create(['name' => 'list legal pages']);

        //permission for blogs
        Permission::create(['name' => 'edit blogs']);
        Permission::create(['name' => 'delete blogs']);
        Permission::create(['name' => 'create blogs']);
        Permission::create(['name' => 'list blogs']);

        //permission for testimonials
        Permission::create(['name' => 'edit testimonials']);
        Permission::create(['name' => 'delete testimonials']);
        Permission::create(['name' => 'create testimonials']);
        Permission::create(['name' => 'list testimonials']);

        //permission for charges
        Permission::create(['name' => 'edit charges']);
        Permission::create(['name' => 'delete charges']);
        Permission::create(['name' => 'create charges']);
        Permission::create(['name' => 'list charges']);

        //permission for orders
        Permission::create(['name' => 'edit orders']);
        Permission::create(['name' => 'delete orders']);
        Permission::create(['name' => 'create orders']);
        Permission::create(['name' => 'list orders']);


        //permission for about page content
        Permission::create(['name' => 'edit about page content']);

        //permission for features
        Permission::create(['name' => 'edit features']);
        Permission::create(['name' => 'delete features']);
        Permission::create(['name' => 'create features']);
        Permission::create(['name' => 'list features']);

        //permission for categories
        Permission::create(['name' => 'edit categories']);
        Permission::create(['name' => 'delete categories']);
        Permission::create(['name' => 'create categories']);
        Permission::create(['name' => 'list categories']);

        //permission for products
        Permission::create(['name' => 'edit products']);
        Permission::create(['name' => 'delete products']);
        Permission::create(['name' => 'create products']);
        Permission::create(['name' => 'list products']);

    }
}