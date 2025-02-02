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
            $table->foreignId('provider_id')->constrained('providers')->onDelete('cascade');
            $table->string("job_title", 255);
            $table->text("job_description");
            $table->foreignId('governments_id')->constrained('governments');
            $table->text("image");
            $table->boolean("is_urgent")->default(false);
            $table->foreignId('sub_specialization_id')->constrained('sub_specializations');
            $table->double('start_price');
            $table->double('end_price');
            $table->enum('salary_type', ['monthly', 'weekly']);
            $table->enum('contract_type', ['full_time', 'part_time', 'hourly']);
            $table->date('expiration_date');
            $table->integer('years_of_experience');
            $table->enum('gender', ['male', 'female', 'both'])->default('both');
            $table->text("qualifications");
            $table->text("key_responsibilities");
            $table->text("skill_and_experience");
            $table->text("job_skills");
            $table->string("job_location", 255);
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
