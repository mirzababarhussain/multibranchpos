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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->longText('customer_code')->nullable();
            $table->longText('name');
            $table->longText('cnic')->nullable();
            $table->longText('phone');
            $table->longText('email')->nullable();
            $table->longText('address');
            $table->integer('branch_id');
            $table->integer('created_by');
            $table->integer('disable')->default(0); // 0 for enable, 1 fore disabled
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
