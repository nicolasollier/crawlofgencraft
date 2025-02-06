<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoomsTable extends Migration
{
    public function up()
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dungeon_id')->constrained()->onDelete('cascade');
            $table->integer('room_number');
            $table->enum('type', ['start', 'encounter', 'trapped', 'treasure', 'enigma', 'empty', 'exit', 'playerLost']);
            $table->text('description');
            $table->json('options')->nullable();
            $table->boolean('is_success')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('rooms');
    }
}
