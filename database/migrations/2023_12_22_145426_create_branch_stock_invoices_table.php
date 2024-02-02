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
        Schema::create('branch_stock_invoices', function (Blueprint $table) {
            $table->id();
            $table->integer('branch_id');
            $table->longText('stock_inv_date');
            $table->longText('inv_status'); // Initiated, In Process, Received.
            $table->integer('created_by'); // user id that create stock invoice. usually admin.
            $table->integer('received_by')->default(0); // user id of respective that will confirm stock
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('branch_stock_invoices');
    }
};
