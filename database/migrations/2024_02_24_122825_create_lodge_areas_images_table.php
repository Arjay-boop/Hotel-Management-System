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
        Schema::create('lodge_areas_images', function (Blueprint $table) {
            $table->id('img_id');
            $table->unsignedBigInteger('lodge_id');
            $table->string('img');
            $table->timestamps();

            $table->foreign('lodge_id')->references('lodge_id')->on('lodge_areas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lodge_areas_images');
    }
};
