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
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->text('skills');
            $table->integer('experience');
            $table->string('contract_type');
            $table->date('expiry_date');
            $table->enum('status', ['hired', 'searching'])->default('searching');
            $table->enum('gender', ['male', 'female', 'any'])->default('any');
            $table->integer('salary')->nullable();
            $table->foreignId('sub_specializations_id')->constrained('sub_specializations')->onDelete('cascade');
            $table->foreignId('government_id')->constrained('governments')->onDelete('cascade');
            $table->foreignId('employer_id')->constrained('providers')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jobs');
    }
};