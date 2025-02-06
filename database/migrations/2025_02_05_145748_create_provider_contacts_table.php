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
        Schema::create('provider_contacts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('provider_id')->constrained('providers')->onDelete('cascade');
            $table->string('phone', 255)->nullable();
            $table->string('email', 255)->nullable();
            $table->string('whatsapp', 255)->nullable();
            $table->string('telegram', 255)->nullable();
            $table->string('instagram', 255)->nullable();
            $table->string('facebook', 255)->nullable();
            $table->string('linkedin', 255)->nullable();
            $table->string('website', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('provider_contacts');
    }
};