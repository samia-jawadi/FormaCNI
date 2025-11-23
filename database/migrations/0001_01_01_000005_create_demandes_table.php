<?php
// database/migrations/2024_01_01_000003_create_demandes_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('demandes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('formateur_id')->constrained('users')->onDelete('cascade');
            $table->string('titre');
            $table->text('description');
            $table->integer('duree_proposee');
            $table->enum('statut', ['EN_ATTENTE', 'ACCEPTEE', 'REFUSEE'])->default('EN_ATTENTE');
            $table->text('raison_refus')->nullable();
            $table->timestamp('date_soumission')->useCurrent();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('demandes');
    }
};