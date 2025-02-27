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
        Schema::create('pakages', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('slug')->nullable();
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('language_id');
            $table->unsignedBigInteger('state_id');
            $table->string('duration')->nullable();
            $table->longText('short_description')->nullable();
            $table->longText('description')->nullable();
            $table->double('lowest_price',8,2)->unsigned()->default(0);
            $table->double('total_price',8,2)->unsigned()->default(0);
            $table->longText('tour_inclusion')->nullable();
            $table->longText('tour_exclusion')->nullable();
            $table->longText('booking_policy')->nullable();
            $table->longText('cancellation_policy')->nullable();
            $table->longText('summary')->nullable();
            $table->tinyInteger('status')->default(1)->comment('1 => Active, 0 => Inactive');
            $table->tinyInteger('top_selling')->default(0)->comment('1 => Yes, 0 => No');
            $table->string('rated')->nullable();
            $table->string('review')->nullable();
            $table->timestamps(); 
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->foreign('language_id')->references('id')->on('languages')->onDelete('cascade');
            $table->foreign('state_id')->references('id')->on('states')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pakages');
    }
};
