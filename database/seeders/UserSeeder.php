<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Méthode sécurisée pour vider la table
        DB::table('users')->delete();

        // Réinitialiser l'auto-incrément pour MySQL
        DB::statement('ALTER TABLE users AUTO_INCREMENT = 1');

        // Créer un administrateur
        User::create([
            'nom' => 'Administrateur',
            'email' => 'admin@formacni.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'est_actif' => true,
            'date_inscription' => now(),
        ]);

        // Créer des formateurs

        User::create([
            'nom' => 'Fatima Zohra',
            'email' => 'formateur2@formacni.com',
            'password' => Hash::make('password123'),
            'role' => 'formateur',
            'est_actif' => true,
            'specialite' => 'Design Graphique',
            'experience' => 3,
            'date_inscription' => now(),
        ]);

        // Créer des participants
        $participants = [
            ['nom' => 'Karim Mohamed', 'email' => 'participant1@formacni.com', 'niveau' => 'Débutant'],
         
        ];

        foreach ($participants as $participant) {
            User::create([
                'nom' => $participant['nom'],
                'email' => $participant['email'],
                'password' => Hash::make('password123'),
                'role' => 'participant',
                'est_actif' => true,
                'niveau' => $participant['niveau'],
                'date_inscription' => now(),
            ]);
        }
    }
}