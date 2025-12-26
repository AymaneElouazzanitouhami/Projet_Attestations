<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('demandes', function (Blueprint $table) {
            $table->id('id_demande');
            $table->foreignId('id_etudiant')->constrained('etudiants', 'id_etudiant');
            $table->enum('type_document', ['scolarite', 'releve_notes', 'reussite', 'convention_stage']);
            $table->enum('statut', ['en_attente', 'validee', 'refusee'])->default('en_attente');
            $table->dateTime('date_demande')->useCurrent();
            $table->string('annee_universitaire', 50)->nullable();
            $table->integer('semestre')->nullable();
            $table->foreignId('id_admin_traitant')->nullable()->constrained('administrateurs', 'id_admin');
            $table->dateTime('date_traitement')->nullable();
            $table->text('motif_refus')->nullable();
            $table->timestamps();
        });

        // Définir l'auto-increment à 1233
        DB::statement('ALTER TABLE demandes AUTO_INCREMENT = 1233');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('demandes');
    }
};