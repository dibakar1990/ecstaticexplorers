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
        Schema::create('home_stay_facilities', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('home_stay_id');
            $table->string('title')->nullable();
            $table->string('file_path')->nullable();
            $table->string('beds')->nullable();
            $table->string('occupancy')->nullable();
            $table->string('view')->nullable();
            $table->string('toilet_with_geyser')->nullable();
            $table->string('attached_toilet')->nullable();
            $table->timestamps();
            $table->foreign('home_stay_id')->references('id')->on('home_stays')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('home_stay_facilities');
    }
};
