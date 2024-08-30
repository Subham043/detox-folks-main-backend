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
        Schema::create('order_products', function (Blueprint $table) {
            $table->id();
            $table->string('name', 500);
            $table->string('slug', 500);
            $table->text('brief_description')->nullable();
            $table->string('image', 500)->nullable();
            $table->string('min_quantity', 500);
            $table->string('price', 500);
            $table->string('discount', 500);
            $table->string('discount_in_price', 500);
            $table->string('quantity', 500);
            $table->string('amount', 500);
            $table->string('color', 500)->nullable();
            $table->string('unit', 500)->default('pieces');
            $table->foreignId('order_id')->nullable()->constrained('orders')->nullOnDelete();
            $table->timestamps();
            $table->index(['id', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_products');
    }
};

// ALTER TABLE `order_products` ADD `color` VARCHAR(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL AFTER `amount`;
