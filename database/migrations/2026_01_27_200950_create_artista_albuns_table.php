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
        Schema::create('artista_album', function (Blueprint $table) {     
            $table->id();                   
            $table->foreignId('art_id')->constrained('artista', 'id');
            $table->foreignId('alb_id')->constrained('album', 'id');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('artista_album');
    }
};
