<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JobCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Lập trình & Phát triển phần mềm',
            'Khoa học dữ liệu & Trí tuệ nhân tạo',
            'DevOps & Cloud',
            'An toàn thông tin (Cyber Security)',
            'Quản trị hệ thống & mạng',
            'Thiết kế & Sáng tạo công nghệ',
            'Quản lý dự án & phân tích nghiệp vụ',
            'Kiểm thử & Đảm bảo chất lượng',
            'Web, Hosting & Hạ tầng Internet',
            'Blockchain & Công nghệ Web3',
            'Phần cứng, IoT & điện tử',
            'Sales & Support kỹ thuật',
            'Nội dung kỹ thuật',
        ];

        foreach ($categories as $categoryName) {
            DB::table('job_categories')->insertOrIgnore([
                'category_name' => $categoryName,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}

