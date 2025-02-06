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
        Schema::create('car_returns', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_tenant');
            $table->unsignedBigInteger('id_car');
            $table->unsignedBigInteger('id_penalties');
            $table->date('date_borrow');
            $table->date('date_return');
            $table->string('penalties_total');
            $table->string('discount');
            $table->string('total');
            $table->timestamps();

            $table->foreign('id_tenant')->references('id')->on('users');
            $table->foreign('id_car')->references('id')->on('cars');
            $table->foreign('id_penalties')->references('id')->on('penalties');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('car_returns');
    }
};
