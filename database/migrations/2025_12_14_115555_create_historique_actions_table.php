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
        Schema::create('historique_actions', function (Blueprint $table) {
            $table->id('id_historique');
            $table->foreignId('id_demande')->nullable()->constrained('demandes', 'id_demande');
            $table->foreignId('id_reclamation')->nullable()->constrained('reclamations', 'id_reclamation');
            $table->foreignId('id_admin')->nullable()->constrained('administrateurs', 'id_admin');
            $table->string('action_effectuee', 255);
            $table->text('details')->nullable();
            $table->dateTime('date_action')->useCurrent();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historique_actions');
    }
};
