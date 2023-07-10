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
        Schema::create('general_website_settings', function (Blueprint $table) {
            $table->id();
            $table->string('website_logo', 500)->nullable();
            $table->string('website_footer_logo', 500)->nullable();
            $table->string('website_logo_alt', 500)->nullable();
            $table->string('website_logo_title', 500)->nullable();
            $table->string('website_favicon', 500)->nullable();
            $table->string('website_name', 500)->nullable();
            $table->string('email', 500)->nullable();
            $table->string('phone', 500)->nullable();
            $table->string('address', 500)->nullable();
            $table->string('facebook', 500)->nullable();
            $table->string('instagram', 500)->nullable();
            $table->string('linkedin', 500)->nullable();
            $table->string('youtube', 500)->nullable();
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
        Schema::dropIfExists('general_website_settings');
    }
};
