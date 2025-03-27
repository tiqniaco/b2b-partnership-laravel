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
        Schema::create('product_description_contents', function (Blueprint $table) {
            $table->id();
            $table->text('content_en');
            $table->text('content_ar');
            $table->foreignId('title_id')->constrained("product_description_titles")->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_description_contents');
    }
};
