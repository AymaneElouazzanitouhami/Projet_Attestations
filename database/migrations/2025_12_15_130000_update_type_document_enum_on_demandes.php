<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Ensure the demandes.type_document enum contains convention_stage.
     */
    public function up(): void
    {
        DB::statement("
            ALTER TABLE demandes
            MODIFY type_document ENUM('scolarite','releve_notes','reussite','convention_stage')
            NOT NULL
        ");
    }

    /**
     * Revert to the previous enum values (without convention_stage).
     */
    public function down(): void
    {
        DB::statement("
            ALTER TABLE demandes
            MODIFY type_document ENUM('scolarite','releve_notes','reussite')
            NOT NULL
        ");
    }
};

