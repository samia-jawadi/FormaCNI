<?php

namespace Database\Seeders;

use App\Models\Formation;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FormationSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('formations')->delete();
        DB::statement('ALTER TABLE formations AUTO_INCREMENT = 1');

        $formateurs = User::where('role', 'formateur')->get();

        Formation::create([
            'titre' => 'Développement Web Fullstack',
            'description' => 'Formation complète en développement web frontend et backend avec HTML, CSS, JavaScript, PHP et MySQL.',
            'duree' => 40,
            'date_debut' => now()->addDays(7),
            'date_fin' => now()->addDays(37),
            'heure_debut' => '09:00:00',
            'capacite_max' => 15,
            'statut' => 'ACTIVE',
            'formateur_id' => $formateurs[0]->id,
        ]);

        Formation::create([
            'titre' => 'JavaScript Moderne',
            'description' => 'Maîtrisez les concepts modernes de JavaScript, ES6+, Node.js, et les frameworks frontend.',
            'duree' => 30,
            'date_debut' => now()->addDays(14),
            'date_fin' => now()->addDays(44),
            'heure_debut' => '14:00:00',
            'capacite_max' => 12,
            'statut' => 'ACTIVE',
            'formateur_id' => $formateurs[0]->id,
        ]);
    }
}