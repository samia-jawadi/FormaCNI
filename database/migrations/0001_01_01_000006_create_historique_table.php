<?php
// database/migrations/2024_01_01_000004_create_historiques_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('historiques', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('formation_id')->nullable()->constrained('formations')->onDelete('set null');
            $table->foreignId('user_concerne_id')->nullable()->constrained('users')->onDelete('set null');
            $table->enum('type_action', [
                'CREATION_FORMATION',
                'MODIFICATION_FORMATION', 
                'SUPPRESSION_FORMATION',
                'INSCRIPTION',
                'DESINSCRIPTION',
                'CONNEXION',
                'DESACTIVATION_COMPTE',
                'VALIDATION_DEMANDE',
                'REFUS_DEMANDE'
            ]);
            $table->text('details');
            $table->timestamp('date_action')->useCurrent();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('historiques');
    }
};