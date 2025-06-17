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
        Schema::create('home_page_banners', function (Blueprint $table) {
            $table->id();
            $table->string('desktop_image', 500)->nullable();
            $table->string('mobile_image', 500)->nullable();
            $table->string('image_title', 500)->nullable();
            $table->string('image_alt', 500)->nullable();
            $table->boolean('is_draft')->default(0);
            $table->timestamps();
            $table->index(['id', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('home_page_banners');
    }
};
