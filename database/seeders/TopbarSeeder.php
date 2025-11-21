<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Topbar;

class TopbarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Topbar::create([
            'phone' => '+223 92190993',
            'email' => 'contact@synem.ml',
            'facebook_url' => null,
            'twitter_url' => null,
            'linkedin_url' => null,
            'instagram_url' => null,
        ]);
    }
}
