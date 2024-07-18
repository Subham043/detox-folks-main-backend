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
        Schema::create('charges', function (Blueprint $table) {
            $table->id();
            $table->string('charges_slug', 500);
            $table->string('charges_name', 500);
            $table->string('charges_in_amount', 500)->default(0)->nullable();
            $table->boolean('is_percentage')->default(0);
            $table->string('include_charges_for_cart_price_below', 500)->default(0)->nullable();
            $table->boolean('is_active')->default(0);
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('charges');
    }
};

// ALTER TABLE `charges` ADD `is_percentage` TINYINT(1) NOT NULL DEFAULT '0' AFTER `charges_in_amount`;