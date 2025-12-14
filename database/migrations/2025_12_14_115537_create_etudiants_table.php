<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('etudiants', function (Blueprint $table) {
            $table->id('id_etudiant');
            $table->string('nom', 100);
            $table->string('prenom', 100);
            $table->string('email', 255)->unique();
            $table->string('cin', 50)->unique();
            $table->string('numero_apogee', 50)->unique();
            $table->integer('niveau_actuel');
            $table->string('filiere_actuelle', 100)->nullable();
            $table->enum('statut_inscription', ['inscrit', 'non_inscrit'])->default('inscrit');
            $table->boolean('parcours_sans_redoublement')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('etudiants');
    }
};
