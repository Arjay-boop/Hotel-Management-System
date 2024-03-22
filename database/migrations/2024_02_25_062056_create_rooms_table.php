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
        Schema::create('rooms', function (Blueprint $table) {
            $table->id('room_id');
            $table->unsignedBigInteger('lodge_id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('room_no');
            $table->string('room_type');
            $table->string('bed_type');
            $table->string('occupants');
            $table->string('status');
            $table->string('size');
            $table->decimal('price', 10, 2)->default(0);
            $table->text('description');
            $table->timestamps();

            $table->foreign('lodge_id')->references('lodge_id')->on('lodge_areas')->onDelete('cascade');
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
