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
        Schema::table('conventions_stage', function (Blueprint $table) {
            $table->unsignedBigInteger('id_demande')->after('id_convention');
        });
    }

    public function down(): void
    {
        Schema::table('conventions_stage', function (Blueprint $table) {
            $table->dropColumn('id_demande');
        });
    }
};
