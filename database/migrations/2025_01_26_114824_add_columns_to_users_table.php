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
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone', 25)->nullable();
            $table->string('country_code', 10)->nullable();
            $table->enum('role', ['client', 'service_provider', 'admin'])->default('client');
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->integer('otp')->nullable()->constrained(6);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
