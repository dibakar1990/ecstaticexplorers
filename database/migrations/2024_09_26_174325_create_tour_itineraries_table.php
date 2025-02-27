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
        Schema::create('tour_itineraries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pakage_id')->nullable(); 
            $table->unsignedBigInteger('type_id')->nullable();
            $table->string('day_no')->nullable();
            $table->string('title')->nullable();
            $table->tinyInteger('check_in')->default(1)->comment('1 => Active, 0 => Inactive'); 
            $table->tinyInteger('sight_seeing')->default(1)->comment('1 => Active, 0 => Inactive'); 
            $table->text('text')->nullable();
            $table->string('stay_at')->nullable(); 
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
        Schema::dropIfExists('tour_itineraries');
    }
};
