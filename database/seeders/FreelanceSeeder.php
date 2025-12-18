<?php

namespace Database\Seeders;

use App\Models\Freelance;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class FreelanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Tạo Freelance 1 (nếu chưa tồn tại)
        Freelance::firstOrCreate(
            ['email' => 'freelance1@vietlance.com'],
            [
                'name' => 'Nguyễn Văn A',
                'password' => Hash::make('password'),
                'phone' => '0912345678',
                'address' => 'Hà Nội, Việt Nam',
                'bio' => 'Full-stack developer với 5 năm kinh nghiệm',
                'skills' => 'PHP, Laravel, JavaScript, Vue.js, MySQL',
                'hourly_rate' => 25.00,
                'experience_years' => 5,
                'is_active' => true,
            ]
        );

        // Tạo Freelance 2 (nếu chưa tồn tại)
        Freelance::firstOrCreate(
            ['email' => 'freelance2@vietlance.com'],
            [
                'name' => 'Trần Thị B',
                'password' => Hash::make('password'),
                'phone' => '0923456789',
                'address' => 'TP. Hồ Chí Minh, Việt Nam',
                'bio' => 'UI/UX Designer chuyên nghiệp',
                'skills' => 'Figma, Adobe XD, Photoshop, Illustrator',
                'hourly_rate' => 20.00,
                'experience_years' => 3,
                'is_active' => true,
            ]
        );
    }
}

