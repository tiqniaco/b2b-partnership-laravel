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
        Schema::create('request_services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('clients')->onDelete('cascade');
            $table->foreignId('governments_id')->constrained('governments');
            $table->foreignId('sub_specialization_id')->constrained('sub_specializations');
            $table->string('title_ar', 255);
            $table->string('title_en', 255);
            $table->text('address');
            $table->text('description');
            $table->text('image');
            $table->string('duration');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('request_services');
    }
};
