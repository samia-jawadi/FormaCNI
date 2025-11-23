<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Formation;
use App\Models\Inscription;
use App\Models\Demande;

class RefreshTimestamps extends Command
{
    protected $signature = 'dev:refresh-timestamps';
    protected $description = 'Refresh database timestamps for development purposes';

    public function handle()
    {
        $this->info('Refreshing database timestamps...');
        
        // Update users with recent timestamps
        User::chunk(100, function ($users) {
            foreach ($users as $user) {
                $user->update([
                    'created_at' => now()->subMinutes(rand(1, 480)), // Last 8 hours
                    'updated_at' => now()->subMinutes(rand(0, 60))   // Last hour
                ]);
            }
        });
        
        // Update formations
        Formation::chunk(100, function ($formations) {
            foreach ($formations as $formation) {
                $formation->update([
                    'created_at' => now()->subMinutes(rand(60, 1440)), // Last 24 hours
                    'updated_at' => now()->subMinutes(rand(0, 120))    // Last 2 hours
                ]);
            }
        });
        
        // Update inscriptions
        Inscription::chunk(100, function ($inscriptions) {
            foreach ($inscriptions as $inscription) {
                $inscription->update([
                    'created_at' => now()->subMinutes(rand(30, 720)), // Last 12 hours
                    'updated_at' => now()->subMinutes(rand(0, 90))    // Last 1.5 hours
                ]);
            }
        });
        
        // Update demandes
        Demande::chunk(100, function ($demandes) {
            foreach ($demandes as $demande) {
                $demande->update([
                    'created_at' => now()->subMinutes(rand(120, 2160)), // Last 36 hours
                    'updated_at' => now()->subMinutes(rand(0, 180))     // Last 3 hours
                ]);
            }
        });
        
        // Create a few very recent activities
        $this->createRecentActivities();
        
        $this->info('✅ Database timestamps refreshed successfully!');
        $this->info('📊 Recent activities have been created with precise timestamps.');
        
        return 0;
    }
    
    private function createRecentActivities()
    {
        // Create user 30 seconds ago
        User::create([
            'nom' => 'Utilisateur Test ' . now()->format('H:i'),
            'email' => 'recent_' . time() . '@test.com',
            'password' => bcrypt('password'),
            'role' => 'participant',
            'est_actif' => true,
            'niveau' => 'débutant',
            'created_at' => now()->subSeconds(30),
            'updated_at' => now()->subSeconds(30)
        ]);
        
        // Create user 2 minutes ago
        User::create([
            'nom' => 'Formateur Récent ' . now()->format('H:i'),
            'email' => 'recent_form_' . time() . '@test.com',
            'password' => bcrypt('password'),
            'role' => 'formateur',
            'est_actif' => true,
            'specialite' => 'Développement Web',
            'experience' => 2,
            'created_at' => now()->subMinutes(2),
            'updated_at' => now()->subMinutes(2)
        ]);
        
        // Create user 15 minutes ago
        User::create([
            'nom' => 'Admin Test ' . now()->format('H:i'),
            'email' => 'recent_admin_' . time() . '@test.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
            'est_actif' => true,
            'created_at' => now()->subMinutes(15),
            'updated_at' => now()->subMinutes(15)
        ]);
    }
}