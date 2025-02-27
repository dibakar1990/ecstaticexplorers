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
        Schema::create('states', function (Blueprint $table) {
            $table->id();
            $table->integer('sl_no')->nullable(); 
            $table->string('name')->unique()->nullable();
            $table->double('starting_price')->default(0);
            $table->string('destination')->nullable();
            $table->string('hotels')->nullable();
            $table->string('tourist')->nullable();
            $table->string('tour')->nullable();
            $table->string('slug')->nullable();
            $table->string('file_path')->nullable();
            $table->tinyInteger('status')->default(1)->comment('1 => Active, 0 => Inactive');
            $table->tinyInteger('trending')->default(0)->comment('1 => Yes, 0 => No');
            $table->tinyInteger('explore_state')->default(1)->comment('1 => Yes, 0 => No');
            $table->tinyInteger('explore_unexplore')->default(1)->comment('1 => Yes, 0 => No'); 
            $table->tinyInteger('is_home_stay')->default(1)->comment('1 => Yes, 0 => No'); 
            $table->timestamps(); 
        }); 
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('states');
    }
};
