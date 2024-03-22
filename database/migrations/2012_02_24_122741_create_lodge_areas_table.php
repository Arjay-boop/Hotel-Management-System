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
        Schema::create('lodge_areas', function (Blueprint $table) {
            $table->id('lodge_id');
            $table->string('area');
            $table->string('total_rooms');
            $table->string('status');
            $table->integer('available_rooms')->default(0);
            $table->string('location');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lodge_areas');
    }
};
