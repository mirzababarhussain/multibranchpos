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
        Schema::create('branch_sale_return_masters', function (Blueprint $table) {
            $table->id();
            $table->longText('ret_inv_date')->nullable();
            $table->integer('customer_id')->nullable();
            $table->integer('branch_id')->nullable();
            $table->longText('ret_inv_code');
            $table->integer('ret_inv_status')->default(0); // 0 for incomplete, 1 for on hold, 2 for completed.
            $table->integer('user_id');
            $table->longText('total_sale_return')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('branch_sale_return_masters');
    }
};
