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
        Schema::create('previous_work_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('provider_previous_work_id')->constrained('provider_previous_works')->onDelete('cascade');
            $table->text('image');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('previous_work_images');
    }
};
