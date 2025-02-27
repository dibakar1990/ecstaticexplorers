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
        Schema::create('home_stay_images', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('home_stay_id');
            $table->string('file_path')->nullable();
            $table->tinyInteger('default_status')->default(0)->comment('1 => Default, 0 => Not Default');            
            $table->timestamps();
            $table->foreign('home_stay_id')->references('id')->on('home_stays')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('home_stay_images');
    }
};
