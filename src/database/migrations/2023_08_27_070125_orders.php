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
            $table->string('country', 255)->nullable();
            $table->string('state', 255)->nullable();
            $table->string('city', 255)->nullable();
            $table->string('pin', 255)->nullable();
            $table->text('address')->nullable();
            $table->string('coupon_name', 500);
            $table->string('coupon_code', 500)->nullable();
            $table->text('coupon_description')->nullable();
            $table->string('coupon_discount', 500)->default(0)->nullable();
            $table->string('coupon_maximum_dicount_in_price', 500)->nullable();
            $table->string('coupon_maximum_number_of_use', 500)->nullable();
            $table->string('coupon_minimum_cart_value', 500)->nullable();
            $table->string('tax_slug', 500);
            $table->string('tax_name', 500);
            $table->string('tax_in_percentage', 500)->default(0)->nullable();
            $table->string('subtotal', 500)->default(0)->nullable();
            $table->string('total_tax', 500)->default(0)->nullable();
            $table->string('total_charges', 500)->default(0)->nullable();
            $table->string('discount_price', 500)->default(0)->nullable();
            $table->string('total_price', 500)->default(0)->nullable();
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
