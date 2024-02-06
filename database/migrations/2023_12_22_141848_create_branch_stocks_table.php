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
        Schema::create('branch_stocks', function (Blueprint $table) {
            $table->id();
            $table->integer('branch_id');
            $table->integer('product_id');
            $table->longText('unit');
            $table->longText('size');
            $table->integer('stock')->default(0);
            $table->longText('custom_sale_price')->nullable();
            $table->longText('custom_profile')->nullable();
            $table->longText('internal_barcode')->nullable();
            $table->longText('external_barcode')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('branch_stocks');
    }
};
