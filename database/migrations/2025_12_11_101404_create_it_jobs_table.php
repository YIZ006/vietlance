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
        Schema::create('it_jobs', function (Blueprint $table) {
            $table->id('job_id');
            $table->string('job_title', 255);
            $table->unsignedBigInteger('category_id')->nullable();
            $table->text('short_description')->nullable();
            $table->timestamps();

            $table->foreign('category_id')
                  ->references('category_id')
                  ->on('job_categories')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('it_jobs');
    }
};

