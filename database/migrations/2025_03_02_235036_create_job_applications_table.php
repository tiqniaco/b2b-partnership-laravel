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
        Schema::create('job_applications', function (Blueprint $table) {
            $table->id();
            $table->integer('years_of_experience')->unsigned();
            $table->text('cover_letter')->nullable();
            $table->text('resume')->nullable();
            $table->json('skills')->nullable();
            $table->date('available_to_start_date')->nullable();
            $table->integer('expected_salary')->unsigned()->nullable();
            $table->text('why_ideal_candidate')->nullable();
            $table->foreignId('job_id')->constrained('jobs')->onDelete('cascade');
            $table->foreignId('client_id')->constrained('clients')->onDelete('cascade');
            $table->enum('status', ['pending', 'accepted', 'rejected'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_applications');
    }
};