<?php
// database/migrations/2024_01_01_000001_create_formations_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
      Schema::create('formations', function (Blueprint $table) {
    $table->id();
    $table->string('titre');
    $table->text('description');
    $table->integer('duree');
    $table->unsignedBigInteger('formateur_id'); // bien préciser unsigned
    $table->date('date_debut');
    $table->date('date_fin');
    $table->time('heure_debut');
    $table->integer('capacite_max');
    $table->enum('statut', ['ACTIVE', 'ATTENTE_VALIDATION'])->default('ATTENTE_VALIDATION');
    $table->timestamps();

    $table->foreign('formateur_id')->references('id')->on('users')->onDelete('cascade');
});

    }

    public function down()
    {
        Schema::dropIfExists('formations');
    }
};