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
        Schema::create('quotes', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number')->nullable();
            $table->string('place_of_supply')->nullable();
            $table->string('transaction_category')->nullable();
            $table->string('date')->nullable();
            $table->string('transaction_type')->nullable();
            $table->string('document_type')->nullable();
            $table->string('location')->nullable();
            $table->string('customer_name')->nullable();
            $table->string('travel_date')->nullable();
            $table->string('customer_contact_number')->nullable();
            $table->string('total_pax')->nullable();
            $table->string('number_of_adult')->nullable();
            $table->string('number_of_children')->nullable();
            $table->string('number_of_infant')->nullable();
            $table->string('pick_up_point')->nullable();
            $table->string('drop_point')->nullable();
            $table->string('transportation')->nullable();
            $table->string('no_of_room')->nullable();
            $table->string('meal_plan')->nullable();
            $table->longText('accommodation')->nullable();
            $table->longText('cost_breakup')->nullable();
            $table->longText('itinerary')->nullable(); 
            $table->longText('package_inclusion')->nullable(); 
            $table->longText('package_exclusion')->nullable(); 
            $table->longText('mode_of_payment')->nullable(); 
            $table->longText('term_condition')->nullable(); 
            $table->longText('cancellation_policy')->nullable(); 
            $table->timestamps(); 
        }); 
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quotes');
    }
};
