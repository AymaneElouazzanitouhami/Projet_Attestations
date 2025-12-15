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
        Schema::create('conventions_stage', function (Blueprint $table) {
            $table->id('id_convention');
            $table->foreignId('id_demande')->constrained('demandes', 'id_demande')->onDelete('cascade');
            $table->foreignId('id_etudiant')->constrained('etudiants', 'id_etudiant')->onDelete('cascade');
            $table->string('nom_entreprise', 255);
            $table->text('adresse_entreprise');
            $table->string('email_entreprise', 255);
            $table->string('nom_encadrant_entreprise', 100);
            $table->string('nom_encadrant_ecole', 100);
            $table->text('sujet_stage');
            $table->string('duree_stage', 100);
            $table->date('date_debut')->nullable();
            $table->date('date_fin')->nullable();
            $table->enum('statut', ['en_attente', 'approuvee', 'refusee'])->default('en_attente');
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->timestamp('updated_at')->nullable()->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conventions_stage');
    }
};
