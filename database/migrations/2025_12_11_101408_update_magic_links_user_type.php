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
        // Update existing records
        DB::table('magic_links')
            ->where('user_type', 'freelance')
            ->update(['user_type' => 'talent']);

        // Modify the enum column
        Schema::table('magic_links', function (Blueprint $table) {
            $table->enum('user_type', ['talent', 'client'])->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Update existing records back
        DB::table('magic_links')
            ->where('user_type', 'talent')
            ->update(['user_type' => 'freelance']);

        // Modify the enum column back
        Schema::table('magic_links', function (Blueprint $table) {
            $table->enum('user_type', ['freelance', 'client'])->change();
        });
    }
};




