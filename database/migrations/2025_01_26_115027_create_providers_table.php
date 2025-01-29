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
        Schema::create('providers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('provider_types_id')->constrained('provider_types');
            $table->foreignId('sub_specialization_id')->constrained('sub_specializations');
            $table->foreignId('governments_id')->constrained('governments');
            $table->text('image');
            $table->text('commercial_register');
            $table->text('tax_card');
            $table->text("bio");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_providers');
    }
};
