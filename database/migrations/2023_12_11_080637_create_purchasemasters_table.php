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
        Schema::create('purchasemasters', function (Blueprint $table) {
            $table->id();
            $table->longText('pur_date')->nullable();
            $table->string('pur_status')->default('initiated'); // initiated, draft, in process, confirm received
            $table->integer('vendor_id')->nullable();
            $table->longText('total_pur')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchasemasters');
    }
};
