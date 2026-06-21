<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Création du superadmin (vous)
        User::create([
            'name' => 'Moustapha BARRY',
            'email' => 'barrymoustapha908@gmail.com',
            'password' => Hash::make('superadmin7474'),
            'role' => 'superadmin',
            'email_verified_at' => now(),
        ]);

        // Création d'un admin de test
        User::create([
            'name' => 'Hamara KIDA',
            'email' => 'hamarakida@gmail.com',
            'password' => Hash::make('123456'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        // Création de 2 autres admins de test
        // User::factory()->count(2)->create([
        //     'role' => 'admin',
        // ]);
    }
}