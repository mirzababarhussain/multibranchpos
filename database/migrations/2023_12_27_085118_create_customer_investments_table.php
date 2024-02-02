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
        Schema::create('customer_investments', function (Blueprint $table) {
            $table->id();
            $table->integer('customer_id');
            $table->longText('amount');
            $table->longText('profit_percentage');
            $table->longText('start_date');
            $table->longText('end_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_investments');
    }
};
