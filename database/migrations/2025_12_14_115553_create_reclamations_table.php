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
        Schema::create('reclamations', function (Blueprint $table) {
            $table->id('id_reclamation');
            $table->foreignId('id_demande_concernee')->constrained('demandes', 'id_demande');
            $table->foreignId('id_etudiant')->constrained('etudiants', 'id_etudiant');
            $table->string('sujet', 255);
            $table->text('description');
            $table->enum('statut', ['soumise', 'cloturee'])->default('soumise');
            $table->dateTime('date_reclamation')->useCurrent();
            $table->text('reponse_admin')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reclamations');
    }
};
