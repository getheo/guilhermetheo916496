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
        Schema::create('foto_album', function (Blueprint $table) {            
            $table->unsignedBigInteger('album_id')->foreign()->references('id')->on('album')->onDelete('cascade');
            $table->dateTime('fa_data');
            $table->string('fa_bucket', 255);            
            $table->string('fa_hash', 255)->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('foto_album');
    }
};
