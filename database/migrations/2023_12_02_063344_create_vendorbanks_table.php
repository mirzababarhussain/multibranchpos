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
        Schema::create('vendorbanks', function (Blueprint $table) {
            $table->id();
            $table->integer('v_id'); // vendor_id
            $table->longText('name');
            $table->longText('account_title');
            $table->longText('account_no');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendorbanks');
    }
};
