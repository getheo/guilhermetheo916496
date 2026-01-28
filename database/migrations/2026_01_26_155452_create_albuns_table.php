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
        Schema::create('album', function (Blueprint $table) {
            $table->id();

            $table->foreignId('artista_id')
                ->constrained('artista')
                ->cascadeOnDelete();

            $table->string('alb_titulo');
            $table->date('alb_data_lancamento')->nullable();
            $table->boolean('alb_status')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('album');
    }
};
