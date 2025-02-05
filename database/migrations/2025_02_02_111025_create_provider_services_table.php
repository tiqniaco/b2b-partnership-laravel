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
        Schema::create('provider_services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('provider_id')->constrained('providers')->onDelete('cascade');
            $table->foreignId('governments_id')->constrained('governments');
            $table->foreignId('sub_specialization_id')->constrained('sub_specializations');
            $table->string('name_ar', 255);
            $table->string('name_en', 255);
            $table->text('address')->nullable();
            $table->text('description');
            $table->text('image');
            $table->double('price')->nullable();
            $table->integer('rating')->default(0);
            $table->text('overview');
            $table->string('video', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('provider_services');
    }
};
