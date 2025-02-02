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
        Schema::create('provider_service_features', function (Blueprint $table) {
            $table->id();
            $table->foreignId('provider_service_id')->constrained('provider_services')->onDelete('cascade');
            $table->text('feature_en');
            $table->text('feature_ar');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('provider_service_features');
    }
};
