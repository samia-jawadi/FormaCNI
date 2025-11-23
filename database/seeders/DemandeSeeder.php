<?php

namespace Database\Seeders;

use App\Models\Demande;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DemandeSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('demandes')->delete();
        DB::statement('ALTER TABLE demandes AUTO_INCREMENT = 1');

        $formateurs = User::where('role', 'formateur')->get();

        if ($formateurs->count() >= 1) {
            Demande::create([
                'formateur_id' => $formateurs[0]->id,
                'titre' => 'Formation React Native',
                'description' => 'Formation sur le développement d\'applications mobiles avec React Native et Expo.',
                'duree_proposee' => 35,
                'statut' => 'EN_ATTENTE',
            ]);
        }

        if ($formateurs->count() >= 2) {
            Demande::create([
                'formateur_id' => $formateurs[1]->id,
                'titre' => 'Formation Illustration Digitale',
                'description' => 'Apprendre les techniques d\'illustration numérique avec tablette graphique et logiciels professionnels.',
                'duree_proposee' => 30,
                'statut' => 'EN_ATTENTE',
            ]);
        } elseif ($formateurs->count() >= 1) {
            // Use the same formateur if there's only one
            Demande::create([
                'formateur_id' => $formateurs[0]->id,
                'titre' => 'Formation Illustration Digitale',
                'description' => 'Apprendre les techniques d\'illustration numérique avec tablette graphique et logiciels professionnels.',
                'duree_proposee' => 30,
                'statut' => 'EN_ATTENTE',
            ]);
        }
    }
}