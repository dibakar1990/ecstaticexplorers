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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('app_title')->nullable();
            $table->string('email')->nullable();
            $table->string('mobile')->nullable();
            $table->string('whatsapp_number')->nullable();
            $table->string('location')->nullable();
            $table->string('file_path')->nullable();
            $table->string('file_path_fav_icon')->nullable();
            $table->tinyInteger('theme_style')->default(1)->comment('1 => Light Theme, 0 => Dark Theme');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
