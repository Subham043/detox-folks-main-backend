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
            $table->string('delivery_slot', 255)->nullable();
            $table->text('address')->nullable();
            $table->text('map_information')->nullable();
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

// ALTER TABLE `orders` ADD `map_information` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL AFTER `address`;

// ALTER TABLE `orders` ADD `delivery_slot` VARCHAR(255) NULL DEFAULT NULL AFTER `order_mode`;

//ALTER TABLE `orders` ADD `total_taxes` VARCHAR(500) NOT NULL DEFAULT '0' AFTER `total_charges`;
