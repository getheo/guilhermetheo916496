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
        Schema::table('album', function (Blueprint $table) {
            $table->string('capa_path')->nullable()->after('alb_status');
            //
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('album', function (Blueprint $table) {
            // Remove a coluna caso a migration seja revertida
            $table->dropColumn('capa_path');
        });
    }
};
