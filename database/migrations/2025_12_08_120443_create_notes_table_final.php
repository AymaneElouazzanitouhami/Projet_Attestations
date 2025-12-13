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
        Schema::create('notes', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_etudiant');
            $table->string('module_name');
            $table->decimal('note', 5, 2);
            $table->string('semestre')->default('S1');
            $table->string('annee_universitaire')->default('2024/2025');
            $table->char('resultat', 1)->default('V');
            $table->text('remarques')->nullable();
            $table->timestamps();
            
            $table->index(['id_etudiant']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notes');
    }
};