<?php

namespace Database\Seeders;

use App\Models\Militant;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class MilitantSeeder extends Seeder
{
    public function run(): void
    {
        // Régions du Mali
        $regions = [
            'Bamako',
            'Kayes',
            'Koulikoro',
            'Sikasso',
            'Ségou',
            'Mopti',
            'Tombouctou',
            'Gao',
            'Kidal',
            'Ménaka'
        ];

        // Noms maliens courants
        $prenoms = [
            'Amadou', 'Fatoumata', 'Mamadou', 'Aminata', 'Ibrahim', 'Mariam', 'Ousmane', 'Aïssata', 'Bakary', 'Kadiatou',
            'Modibo', 'Djénéba', 'Youssouf', 'Rokia', 'Abdoulaye', 'Seynabou', 'Moussa', 'Hadja', 'Souleymane', 'Fanta',
            'Boubacar', 'Awa', 'Cheick', 'Nafissatou', 'Lassana', 'Adama', 'Hawa', 'Sidi', 'Diallo', 'Traoré'
        ];

        $noms = [
            'DIAWARA', 'KONATÉ', 'TRAORÉ', 'COULIBALY', 'DIALLO', 'SISSOKO', 'KEITA', 'DOUMBIA', 'SANGARÉ', 'SIDIBÉ',
            'TOURE', 'FANE', 'BA', 'SOW', 'KONE', 'BERTE', 'DIARRA', 'MAIGA', 'CAMARA', 'DIABATE',
            'GOITA', 'SANGARE', 'BAGAYOKO', 'KANTE', 'CISSE', 'DEMbele', 'FALL', 'NIANG', 'BARRY', 'SALL'
        ];

        // Statuts possibles
        $statuts = ['pending', 'approved', 'rejected'];

        // Créer 50 militants avec des données réalistes
        for ($i = 1; $i <= 50; $i++) {
            $prenom = $prenoms[array_rand($prenoms)];
            $nom = $noms[array_rand($noms)];
            $region = $regions[array_rand($regions)];
            $statut = $statuts[array_rand($statuts)];

            // Générer un numéro de téléphone malien
            $numeroTel = '+223 ' . rand(70, 99) . ' ' . rand(10, 99) . ' ' . rand(10, 99) . ' ' . rand(10, 99);

            // Générer un numéro de carte unique
            $numeroCarte = 'SYNEM-' . str_pad($i, 4, '0', STR_PAD_LEFT);

            // Générer un email
            $email = strtolower($prenom . '.' . $nom . rand(1, 999) . '@gmail.com');

            Militant::create([
                'nom' => strtoupper($nom),
                'prenom' => ucfirst(strtolower($prenom)),
                'name' => ucfirst(strtolower($prenom)) . ' ' . strtoupper($nom), // Pour compatibilité
                'email' => $email,
                'tel' => $numeroTel,
                'n_cartes_syndicale' => $numeroCarte,
                'coordinations' => $region,
                'message' => 'Demande d\'adhésion au SYNEM - ' . $region,
                'member_card_photo' => 'militants/default.png', // Photo par défaut
                'status' => $statut,
                'created_at' => now()->subDays(rand(1, 365)), // Dates réparties sur l'année
            ]);
        }

        // Créer quelques militants avec des statuts spécifiques pour les tests
        $militantsSpecifiques = [
            [
                'nom' => 'BARRY',
                'prenom' => 'Moustapha',
                'email' => 'barrymoustapha485@gmail.com',
                'tel' => '+223 74 74 56 69',
                'n_cartes_syndicale' => 'SYNEM-0001',
                'coordinations' => 'Bamako',
                'status' => 'approved'
            ],
            [
                'nom' => 'KONE',
                'prenom' => 'Fatoumata',
                'email' => 'fatou.kone@gmail.com',
                'tel' => '+223 76 12 34 56',
                'n_cartes_syndicale' => 'SYNEM-0002',
                'coordinations' => 'Kayes',
                'status' => 'approved'
            ],
            [
                'nom' => 'TRAORE',
                'prenom' => 'Ibrahim',
                'email' => 'ibrahim.traore@gmail.com',
                'tel' => '+223 70 98 76 54',
                'n_cartes_syndicale' => 'SYNEM-0003',
                'coordinations' => 'Sikasso',
                'status' => 'pending'
            ],
            [
                'nom' => 'SIDIBE',
                'prenom' => 'Aminata',
                'email' => 'amina.sidibe@gmail.com',
                'tel' => '+223 90 12 34 56',
                'n_cartes_syndicale' => 'SYNEM-0004',
                'coordinations' => 'Mopti',
                'status' => 'rejected'
            ]
        ];

        foreach ($militantsSpecifiques as $militant) {
            Militant::create(array_merge($militant, [
                'name' => $militant['prenom'] . ' ' . $militant['nom'], // Pour compatibilité
                'message' => 'Demande d\'adhésion au SYNEM',
                'member_card_photo' => 'militants/default.png',
                'created_at' => now()->subDays(rand(1, 30))
            ]));
        }
    }
}