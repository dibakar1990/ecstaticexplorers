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
        Schema::create('cities', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique()->nullable();
            $table->string('slug')->nullable();
            $table->string('file_path')->nullable();
            $table->tinyInteger('status')->default(1)->comment('1 => Active, 0 => Inactive');
            $table->unsignedBigInteger('state_id');
            $table->tinyInteger('top_destination')->default(0)->comment('1 => Top Destination, 0 => Not Top Destination');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cities');
    }
};
