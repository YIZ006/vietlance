<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Check if freelance table exists, if yes rename it to talent
        if (Schema::hasTable('freelance')) {
            Schema::rename('freelance', 'talent');
        }
        
        // If talent table doesn't exist, create it
        if (!Schema::hasTable('talent')) {
            Schema::create('talent', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('email')->unique();
                $table->timestamp('email_verified_at')->nullable();
                $table->string('password');
                $table->string('github_id')->nullable()->unique();
                $table->text('github_token')->nullable();
                $table->text('github_refresh_token')->nullable();
                $table->string('phone')->nullable();
                $table->text('address')->nullable();
                $table->string('avatar')->nullable();
                $table->decimal('hourly_rate', 10, 2)->nullable();
                $table->integer('experience_years')->nullable();
                $table->boolean('is_active')->default(true);
                $table->rememberToken();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Rename back from talent to freelance
        if (Schema::hasTable('talent')) {
            Schema::rename('talent', 'freelance');
        }
    }
};




