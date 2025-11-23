<?php
// database/migrations/2024_01_01_000000_create_users_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('email', 191)->unique();
            $table->string('password');
            $table->enum('role', ['admin', 'formateur', 'participant'])->default('participant');
            $table->timestamp('date_inscription')->useCurrent();
            $table->boolean('est_actif')->default(true);
            
            // Informations spécifiques
            $table->string('pronoms')->nullable();
            $table->string('photo')->nullable();
            $table->string('specialite')->nullable(); // Pour formateur
            $table->integer('experience')->nullable(); // Pour formateur
            $table->string('cv_path')->nullable(); // Pour formateur
            $table->string('niveau')->nullable(); // Pour participant
            $table->json('preferences')->nullable(); // Pour participant
            
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
};