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
        Schema::create('books', function (Blueprint $table) {
            $table->id('book_id');
            $table->unsignedBigInteger('cust_id');
            $table->unsignedBigInteger('room_id');
            $table->unsignedBigInteger('lodge_id');
            $table->date('start_date');
            $table->date('end_date');
            $table->string('status');
            $table->string('file_upload');
            $table->timestamp('booking_date');
            $table->timestamps();

            $table->foreign('cust_id')->references('cust_id')->on('customers');
            $table->foreign('room_id')->references('room_id')->on('rooms');
            $table->foreign('lodge_id')->references('lodge_id')->on('lodge_areas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
