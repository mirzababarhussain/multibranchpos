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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->longText('product_code');
            $table->longText('product_name');
            $table->longText('product_description')->nullable();
            $table->double('pur_price',8,2);
            $table->double('sale_price',8,2);
            $table->integer('disc');
            $table->integer('cate_id');
            $table->integer('disable')->default(0); // 0 for enable, 1 for disabled
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
