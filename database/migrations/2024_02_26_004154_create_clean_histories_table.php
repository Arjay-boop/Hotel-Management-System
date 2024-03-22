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
        Schema::create('clean_histories', function (Blueprint $table) {
            $table->id('clean_id');
            $table->unsignedBigInteger('room_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->timestamp('clean_date');
            $table->timestamps();

            $table->foreign('room_id')->references('room_id')->on('rooms')->onDelete('set Null');
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('set Null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clean_histories');
    }
};
