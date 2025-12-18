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
        Schema::table('talent', function (Blueprint $table) {
            // Xóa các trường đã có trong bảng profiles
            // Giữ lại: name, email, password, phone, address, avatar (cần cho authentication và hiển thị cơ bản)
            // Xóa: bio, skills (đã có trong profiles)
            
            if (Schema::hasColumn('talent', 'bio')) {
                $table->dropColumn('bio');
            }
            
            if (Schema::hasColumn('talent', 'skills')) {
                $table->dropColumn('skills');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('talent', function (Blueprint $table) {
            // Khôi phục lại các trường đã xóa
            $table->text('bio')->nullable()->after('avatar');
            $table->string('skills')->nullable()->after('bio');
        });
    }
};

