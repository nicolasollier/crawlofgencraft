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
        Schema::create('dungeons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('character_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->enum('size', ['small', 'medium', 'large']);
            $table->integer('room_count');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dungeons');
    }
};
