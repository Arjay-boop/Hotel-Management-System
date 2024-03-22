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
        Schema::create('bills', function (Blueprint $table) {
            $table->id('bill_id');
            $table->unsignedBigInteger('book_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('cust_id');
            $table->unsignedBigInteger('room_id');
            $table->unsignedBigInteger('lodge_id');
            $table->decimal('damage_charge', 10, 2)->default(0);
            $table->decimal('total_amount', 10, 2);
            $table->string('status');
            $table->timestamps();

            $table->foreign('book_id')->references('book_id')->on('books');
            $table->foreign('user_id')->references('user_id')->on('users');
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
        Schema::dropIfExists('bills');
    }
};
