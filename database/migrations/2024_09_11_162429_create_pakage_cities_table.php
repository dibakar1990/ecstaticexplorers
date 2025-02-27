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
        Schema::create('pakage_cities', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pakage_id');
            $table->unsignedBigInteger('city_id');
            $table->string('duration')->nullable();
            $table->timestamps();
            $table->foreign('pakage_id')->references('id')->on('pakages')->onDelete('cascade');
            $table->foreign('city_id')->references('id')->on('cities')->onDelete('cascade');
          
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pakage_cities');
    }
};
