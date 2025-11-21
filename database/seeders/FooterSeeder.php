<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Footer;

class FooterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Footer::create([
            'address' => 'Bamako, Mali',
            'phone' => '+223 92190993',
            'email' => 'contact@synem.ml',
            'facebook_url' => null,
            'twitter_url' => null,
            'linkedin_url' => null,
            'copyright_text' => '&copy; SYNEM. Tous droits réservés.',
            'organization_name' => 'Syndicat National des Enseignants du Mali',
            'newsletter_description' => 'Inscrivez-vous pour recevoir les dernières actualités du SYNEM.',
            'gallery_image_1' => null,
            'gallery_image_2' => null,
            'gallery_image_3' => null,
        ]);
    }
}
