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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255)->nullable();
            $table->string('email', 255)->nullable();
            $table->string('phone', 255)->nullable();
            $table->string('otp', 255)->nullable();
            $table->string('gst', 255)->nullable();
            $table->string('country', 255)->nullable();
            $table->string('state', 255)->nullable();
            $table->string('city', 255)->nullable();
            $table->string('pin', 255)->nullable();
            $table->string('order_mode', 255)->nullable();
            $table->text('address')->nullable();
            $table->string('subtotal', 500)->default(0)->nullable();
            $table->string('total_charges', 500)->default(0)->nullable();
            $table->string('total_price', 500)->default(0)->nullable();
            $table->boolean('accept_terms')->default(0);
            $table->boolean('include_gst')->default(0);
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};