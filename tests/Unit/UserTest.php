<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Formation;
use App\Models\Inscription;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;

class UserTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function un_utilisateur_peut_senregistrer_et_se_connecter(): void
    {
        // Création d'un utilisateur
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
        ]);

        // Vérification de l'authentification
        $this->assertTrue(auth()->attempt([
            'email' => 'test@example.com',
            'password' => 'password123'
        ]));
    }

    #[Test]
    public function un_utilisateur_peut_se_desinscrire_dune_formation(): void
    {
        // Création d'un formateur
        $formateur = User::factory()->create(['role' => 'formateur']);

        // Création d'une formation
        $formation = Formation::create([
            'titre' => 'Test Formation',
            'description' => 'Description',
            'duree' => 10,
            'formateur_id' => $formateur->id,
            'date_debut' => now()->toDateString(),
            'date_fin' => now()->addDays(1)->toDateString(),
            'heure_debut' => now()->toTimeString(),
            'capacite_max' => 20,
        ]);

        // Création d'un participant
        $participant = User::factory()->create(['role' => 'participant']);

        // Inscription du participant
        $inscription = Inscription::create([
            'participant_id' => $participant->id,
            'formation_id' => $formation->id,
        ]);

        $this->assertDatabaseHas('inscriptions', [
            'participant_id' => $participant->id,
            'formation_id' => $formation->id,
        ]);

        // Désinscription
        $inscription->delete();

        $this->assertDatabaseMissing('inscriptions', [
            'participant_id' => $participant->id,
            'formation_id' => $formation->id,
        ]);
    }

    #[Test]
    public function un_compte_peut_etre_desactive_et_reactive(): void
    {
        // Création d'un utilisateur
        $user = User::factory()->create([
            'est_actif' => true,
        ]);

        // Désactivation
        $user->est_actif = false;
        $user->save();
        $this->assertFalse($user->fresh()->est_actif);

        // Réactivation
        $user->est_actif = true;
        $user->save();
        $this->assertTrue($user->fresh()->est_actif);
    }
}
