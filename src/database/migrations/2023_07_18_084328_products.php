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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name', 500);
            $table->string('slug', 500)->unique();
            $table->text('description')->nullable();
            $table->text('description_unfiltered')->nullable();
            $table->text('brief_description')->nullable();
            $table->string('image', 500)->nullable();
            $table->boolean('is_draft')->default(0);
            $table->boolean('is_new')->default(0);
            $table->boolean('is_on_sale')->default(0);
            $table->boolean('is_featured')->default(0);
            $table->string('min_cart_quantity', 500)->default(1);
            $table->string('cart_quantity_interval', 500)->default(1);
            $table->text('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('meta_keywords')->nullable();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->index(['id', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
