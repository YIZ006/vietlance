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
        // Check if freelance table exists (before rename) or talent table exists (after rename)
        $tableName = Schema::hasTable('freelance') ? 'freelance' : 'talent';
        
        if (Schema::hasTable($tableName)) {
            Schema::table($tableName, function (Blueprint $table) {
                if (!Schema::hasColumn($tableName, 'github_id')) {
                    $table->string('github_id')->nullable()->unique()->after('email');
                }
                if (!Schema::hasColumn($tableName, 'github_token')) {
                    $table->string('github_token')->nullable()->after('github_id');
                }
                if (!Schema::hasColumn($tableName, 'github_refresh_token')) {
                    $table->string('github_refresh_token')->nullable()->after('github_token');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Check if freelance table exists (before rename) or talent table exists (after rename)
        $tableName = Schema::hasTable('talent') ? 'talent' : 'freelance';
        
        if (Schema::hasTable($tableName)) {
            Schema::table($tableName, function (Blueprint $table) {
                if (Schema::hasColumn($tableName, 'github_id')) {
                    $table->dropColumn(['github_id', 'github_token', 'github_refresh_token']);
                }
            });
        }
    }
};

