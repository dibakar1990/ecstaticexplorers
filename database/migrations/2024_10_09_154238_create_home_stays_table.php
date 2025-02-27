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
        Schema::create('home_stays', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('slug')->nullable();
            $table->unsignedBigInteger('state_id');
            $table->unsignedBigInteger('location_id');
            $table->string('property_classification')->nullable();
            $table->string('property_uniqueness')->nullable();
            $table->string('tariff')->nullable();
            $table->string('price_per_night')->nullable();
            $table->longText('description')->nullable();
            $table->longText('booking_policy')->nullable();
            $table->longText('cancellation_policy')->nullable();
            $table->longText('benefits')->nullable();
            $table->tinyInteger('status')->default(1)->comment('1 => Active, 0 => Inactive');
            $table->timestamps(); 
            $table->foreign('state_id')->references('id')->on('states')->onDelete('cascade');
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('home_stays');
    }
};
