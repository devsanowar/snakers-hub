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
        Schema::create('paymentmethods', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('payment_number')->nullable();
            $table->string('method_type')->nullable();
            $table->string('image')->nullable();
            $table->tinyInteger('is_active')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paymentmethods');
    }
};
