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
        Schema::create('branches', function (Blueprint $table) {
            $table->id();
            $table->longText('branch_code');
            $table->longText('branch_name');
            $table->longText('branch_address');
            $table->longText('branch_contact_person');
            $table->longText('branch_phone');
            $table->longText('branch_email')->nullable();
            $table->longText('branch_opening_balance')->nullable();
            $table->integer('disable')->default(0); // 0 for enable, 1 for disabled
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('branches');
    }
};
