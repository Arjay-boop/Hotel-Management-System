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
        Schema::create('monthly_reports', function (Blueprint $table) {
            $table->id('month_id');
            $table->unsignedBigInteger('lodge_id');
            $table->date('report_date');
            $table->decimal('revenue', 10, 2)->default(0);
            $table->decimal('occupancy_rate', 5, 2)->default(0);
            $table->decimal('damage_rate', 5, 2)->default(0);
            $table->decimal('average_rate', 5, 2)->default(0);
            $table->integer('total_bookings')->default(0);
            $table->json('total_customers_by_gender')->nullable();
            $table->integer('total_rooms')->default(0);
            $table->decimal('total_damage', 10, 2)->default();
            $table->string('event_name')->nullable();
            $table->timestamps();

            $table->foreign('lodge_id')->references('lodge_id')->on('lodge_areas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('monthly_reports');
    }
};
