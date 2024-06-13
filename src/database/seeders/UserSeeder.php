<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Modules\Authentication\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        // gets all permissions via Gate::before rule; see AuthServiceProvider
        $admin_role = Role::create(['name' => 'Super-Admin']);

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
        // User::factory(5)->create();

    }
}