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
        Schema::create('vendors', function (Blueprint $table) {
            $table->id();
            $table->longText('v_code');
            $table->longText('v_name');
            $table->longText('v_phone');
            $table->longText('v_email')->nullable();
            $table->longText('v_address');
            $table->longText('v_contact_name')->nullable();
            $table->longText('v_contact_phone')->nullable();
            $table->longText('v_contact_email')->nullable();
            $table->integer('v_disable')->default(0); // 0 for enable 1 for disabled
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendors');
    }
};
