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
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('talent_id')->unique();
            
            // Profile Overview
            $table->text('profile_overview')->nullable();
            
            // Basic Information
            $table->enum('experience_level', ['entry', 'intermediate', 'expert'])->nullable();
            $table->string('hours_per_week')->nullable(); // e.g., "More than 30 hrs/week"
            $table->boolean('open_to_contract_to_hire')->default(false);
            $table->enum('visibility', ['public', 'private'])->default('public');
            $table->string('project_preference')->nullable();
            $table->boolean('earnings_privacy')->default(false);
            
            // Video Introduction
            $table->string('video_introduction_url')->nullable();
            
            // Languages (stored as JSON or separate table)
            $table->json('languages')->nullable(); // [{"language": "English", "level": "Fluent"}, ...]
            
            // Verifications
            $table->boolean('id_verified')->default(false);
            $table->boolean('military_veteran')->default(false);
            
            // Work History
            $table->json('work_history')->nullable();
            
            // Skills
            $table->json('skills')->nullable(); // ["Translation", "Security Engineering", ...]
            
            // Categories
            $table->string('primary_category')->nullable();
            $table->json('sub_categories')->nullable();
            
            // Specialized Profiles
            $table->json('specialized_profiles')->nullable();
            $table->integer('published_profiles_count')->default(0);
            
            // Linked Accounts
            $table->string('github_username')->nullable();
            $table->string('stackoverflow_username')->nullable();
            $table->string('linkedin_url')->nullable();
            $table->string('portfolio_url')->nullable();
            
            // Certifications
            $table->json('certifications')->nullable();
            
            // Employment History
            $table->json('employment_history')->nullable();
            
            // Other Experiences
            $table->json('other_experiences')->nullable();
            
            // Education
            $table->json('education')->nullable();
            
            // Licenses
            $table->json('licenses')->nullable();
            
            // Project Catalog
            $table->json('project_catalog')->nullable();
            
            // Testimonials
            $table->json('testimonials')->nullable();
            
            // AI Preference
            $table->boolean('ai_data_training_opt_in')->default(false);
            
            $table->timestamps();
            
            // Foreign key
            $table->foreign('talent_id')->references('id')->on('talent')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};

