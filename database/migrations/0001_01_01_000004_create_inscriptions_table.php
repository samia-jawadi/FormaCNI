<?php
// database/migrations/2024_01_01_000002_create_inscriptions_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('inscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('participant_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('formation_id')->constrained('formations')->onDelete('cascade');
            $table->enum('statut', ['EN_ATTENTE', 'CONFIRMEE', 'REFUSEE', 'ANNULEE'])->default('EN_ATTENTE');
            $table->timestamp('date_inscription')->useCurrent();
            $table->timestamps();
            
            $table->unique(['participant_id', 'formation_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('inscriptions');
    }
};