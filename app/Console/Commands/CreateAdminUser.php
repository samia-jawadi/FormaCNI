<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CreateAdminUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:create {email?} {--password=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create or update a user as admin';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email') ?: $this->ask('Enter admin email');
        $password = $this->option('password') ?: $this->secret('Enter admin password');
        
        if (!$email || !$password) {
            $this->error('Email and password are required');
            return 1;
        }
        
        // Check if user exists
        $user = User::where('email', $email)->first();
        
        if ($user) {
            // Update existing user to admin
            $user->update([
                'role' => 'admin',
                'password' => Hash::make($password),
                'est_actif' => true
            ]);
            $this->info("User {$email} has been updated to admin role.");
        } else {
            // Create new admin user
            $nom = $this->ask('Enter admin name', 'Administrator');
            
            $user = User::create([
                'nom' => $nom,
                'email' => $email,
                'password' => Hash::make($password),
                'role' => 'admin',
                'est_actif' => true
            ]);
            $this->info("New admin user {$email} has been created.");
        }
        
        // Display user info
        $this->table(['Field', 'Value'], [
            ['ID', $user->id],
            ['Name', $user->nom],
            ['Email', $user->email],
            ['Role', $user->role],
            ['Active', $user->est_actif ? 'Yes' : 'No'],
            ['Is Admin', $user->isAdmin() ? 'Yes' : 'No']
        ]);
        
        return 0;
    }
}
