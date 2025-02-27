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
        Schema::create('pakage_itinerary_descriptions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pakage_id');
            $table->unsignedBigInteger('type_id');
            $table->longText('tour_itinerary_description')->nullable();
            $table->timestamps();
            $table->foreign('pakage_id')->references('id')->on('pakages')->onDelete('cascade');
            $table->foreign('type_id')->references('id')->on('types')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pakage_itinerary_descriptions');
    }
};
