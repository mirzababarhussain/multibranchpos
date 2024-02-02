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
        Schema::create('ledgers', function (Blueprint $table) {
            $table->id();
            $table->integer('account_id');
            $table->longText('account_type'); //vendor, customer, expense, payable, receivable
            $table->longText('paid_date')->nullable();
            $table->longText('trans_detail')->nullable();
            $table->longText('debit')->nullable();
            $table->longText('credit')->nullable();
            $table->longText('balance')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ledgers');
    }
};
