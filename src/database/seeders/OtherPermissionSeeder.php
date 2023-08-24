<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Spatie\Permission\Models\Permission;
use Illuminate\Database\Seeder;

class OtherPermissionSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        //permission unrelated to main app

        //permission for blogs
        Permission::create(['name' => 'edit blogs']);
        Permission::create(['name' => 'delete blogs']);
        Permission::create(['name' => 'create blogs']);
        Permission::create(['name' => 'list blogs']);

        //permission for partners
        Permission::create(['name' => 'edit partners']);
        Permission::create(['name' => 'delete partners']);
        Permission::create(['name' => 'create partners']);
        Permission::create(['name' => 'list partners']);

        //permission for counters
        Permission::create(['name' => 'edit counters']);
        Permission::create(['name' => 'delete counters']);
        Permission::create(['name' => 'create counters']);
        Permission::create(['name' => 'list counters']);

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

        //permission for home page content
        Permission::create(['name' => 'edit home page content']);
        Permission::create(['name' => 'delete home page content']);
        Permission::create(['name' => 'create home page content']);
        Permission::create(['name' => 'list home page content']);

        //permission for about page content
        Permission::create(['name' => 'edit about page content']);
        Permission::create(['name' => 'delete about page content']);
        Permission::create(['name' => 'create about page content']);
        Permission::create(['name' => 'list about page content']);

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

        //permission for coupon
        Permission::create(['name' => 'edit coupon']);
        Permission::create(['name' => 'delete coupon']);
        Permission::create(['name' => 'create coupon']);
        Permission::create(['name' => 'list coupon']);

        //permission for pages tax
        Permission::create(['name' => 'edit tax']);

        //permission for pages seo
        Permission::create(['name' => 'edit pages seo']);
        Permission::create(['name' => 'list pages seo']);

    }
}
