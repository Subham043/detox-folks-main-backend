<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Modules\Authentication\Models\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // create common permissions
        Permission::create(['name' => 'edit roles']);
        Permission::create(['name' => 'delete roles']);
        Permission::create(['name' => 'create roles']);
        Permission::create(['name' => 'list roles']);
        Permission::create(['name' => 'edit users']);
        Permission::create(['name' => 'delete users']);
        Permission::create(['name' => 'create users']);
        Permission::create(['name' => 'list users']);
        Permission::create(['name' => 'delete enquiries']);
        Permission::create(['name' => 'list enquiries']);
        Permission::create(['name' => 'view application error logs']);
        Permission::create(['name' => 'view application analytics on dashboard']);
        Permission::create(['name' => 'list activity logs']);
        Permission::create(['name' => 'view activity log detail']);
        Permission::create(['name' => 'update sitemap']);
        Permission::create(['name' => 'view general settings detail']);

        //permission for legal pages
        Permission::create(['name' => 'edit legal pages']);
        Permission::create(['name' => 'list legal pages']);

        // gets all permissions via Gate::before rule; see AuthServiceProvider
        $admin_role = Role::create(['name' => 'Super-Admin']);

        // create roles and assign created permissions
        Role::create(['name' => 'staff'])
            ->givePermissionTo(['list users', 'list roles']);

        // create admin
        User::factory()->create([
            'name' => 'Subham Saha',
            'email' => 'subham.5ine@gmail.com',
            'phone' => '7892156160',
            'password' => 'subham',
            'email_verified_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ])->assignRole($admin_role);

        // creates
        User::factory(5)->create();

    }
}
