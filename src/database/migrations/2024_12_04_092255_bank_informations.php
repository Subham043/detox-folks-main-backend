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
        Schema::create('bank_informations', function (Blueprint $table) {
            $table->id();
            $table->string('bank_name', 500)->nullable();
            $table->string('branch_name', 500)->nullable();
            $table->string('ifsc_code', 500)->nullable();
            $table->string('account_no', 500)->nullable();
            $table->string('account_type', 500)->nullable();
            $table->string('upi_id', 500)->nullable();
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
        Schema::dropIfExists('bank_informations');
    }
};
