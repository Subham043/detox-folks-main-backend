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
        Schema::create('order_product_taxes', function (Blueprint $table) {
            $table->id();
            $table->string('tax_slug', 500)->nullable();
            $table->string('tax_name', 500)->nullable();
            $table->string('tax_value', 500)->default(0)->nullable();
            $table->foreignId('order_product_id')->nullable()->constrained('order_products')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_product_taxes');
    }
};


// ALTER TABLE order_taxes RENAME TO order_product_taxes;
// ALTER TABLE `order_product_taxes` CHANGE `order_id` `order_product_id` BIGINT(20) UNSIGNED NULL DEFAULT NULL;
// ALTER TABLE `order_product_taxes` ADD INDEX(`order_product_id`);
// ALTER TABLE `order_product_taxes` ADD CONSTRAINT `order_product_id_foreign` FOREIGN KEY (`order_product_id`) REFERENCES `order_products`(`id`) ON DELETE SET NULL ON UPDATE RESTRICT;
