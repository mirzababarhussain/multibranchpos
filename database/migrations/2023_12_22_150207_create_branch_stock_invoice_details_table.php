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
        Schema::create('branch_stock_invoice_details', function (Blueprint $table) {
            $table->id();
            $table->integer('stock_inv_id');
            $table->integer('product_id');
            $table->longText('unit');
            $table->longText('size');
            $table->longText('issued_stock');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('branch_stock_invoice_details');
    }
};
