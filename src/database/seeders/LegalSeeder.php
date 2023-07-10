<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Modules\Legal\Models\Legal;
use Illuminate\Database\Seeder;

class LegalSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        //legal for main pages

        Legal::create([
            'page_name' => 'Privacy Policy',
            'heading' => 'Privacy Policy',
            'slug' => 'privacy-policy',
            'is_draft' => true
        ]);

        Legal::create([
            'page_name' => 'Cookies Policy',
            'heading' => 'Cookies Policy',
            'slug' => 'cookies-policy',
            'is_draft' => true
        ]);

        Legal::create([
            'page_name' => 'Refund Policy',
            'heading' => 'Refund Policy',
            'slug' => 'refund-policy',
            'is_draft' => true
        ]);

        Legal::create([
            'page_name' => 'Disclaimer',
            'heading' => 'Disclaimer',
            'slug' => 'disclaimer',
            'is_draft' => true
        ]);

        Legal::create([
            'page_name' => 'Terms & Condition',
            'heading' => 'Terms & Condition',
            'slug' => 'terms-condition',
            'is_draft' => true
        ]);
    }
}
