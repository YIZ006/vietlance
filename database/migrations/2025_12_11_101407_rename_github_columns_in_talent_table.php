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
        // This migration assumes the table has already been renamed to 'talent'
        // If github columns don't exist, they will be added
        if (Schema::hasTable('talent')) {
            Schema::table('talent', function (Blueprint $table) {
                if (!Schema::hasColumn('talent', 'github_id')) {
                    $table->string('github_id')->nullable()->unique()->after('password');
                }
                if (!Schema::hasColumn('talent', 'github_token')) {
                    $table->text('github_token')->nullable()->after('github_id');
                }
                if (!Schema::hasColumn('talent', 'github_refresh_token')) {
                    $table->text('github_refresh_token')->nullable()->after('github_token');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('talent', function (Blueprint $table) {
            if (Schema::hasColumn('talent', 'github_id')) {
                $table->dropColumn(['github_id', 'github_token', 'github_refresh_token']);
            }
        });
    }
};




