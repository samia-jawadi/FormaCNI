<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Formation;
use App\Models\Inscription;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

class FunctionalTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function participant_can_register_for_a_formation()
    {
        $participant = User::factory()->create([
            'role' => 'participant',
            'password' => Hash::make('password123')
        ]);

        $formation = Formation::factory()->create([
            'statut' => 'ACTIVE',
            'capacite_max' => 20
        ]);

        $this->actingAs($participant);

        $response = $this->post(route('inscriptions.store'), [
            'participant_id' => $participant->id,
            'formation_id' => $formation->id
        ]);

        $response->assertStatus(302);

        $this->assertDatabaseHas('inscriptions', [
            'participant_id' => $participant->id,
            'formation_id' => $formation->id,
            'statut' => 'EN_ATTENTE'
        ]);
    }

    /** @test */
    public function admin_can_deactivate_a_user_and_user_cannot_login()
    {
        $admin = User::factory()->create([
            'role' => 'admin',
            'password' => Hash::make('adminpass')
        ]);

        $participant = User::factory()->create([
            'role' => 'participant',
            'est_actif' => true,
            'password' => Hash::make('userpass')
        ]);

        $this->actingAs($admin);

        $this->post(route('admin.users.toggle', $participant->id));

        $participant->refresh();
        $this->assertFalse($participant->est_actif);

        // Try logging in
        $this->assertFalse(auth()->attempt([
            'email' => $participant->email,
            'password' => 'userpass'
        ]));
    }

    /** @test */
    public function admin_can_validate_a_formation_proposed_by_formateur()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $formateur = User::factory()->create(['role' => 'formateur']);
        $formation = Formation::factory()->create([
            'formateur_id' => $formateur->id,
            'statut' => 'ATTENTE_VALIDATION'
        ]);

        $this->actingAs($admin);

        $this->post(route('admin.formations.approve', $formation->id));

        $formation->refresh();
        $this->assertEquals('ACTIVE', $formation->statut);
    }
}
