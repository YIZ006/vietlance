<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Talent;
use Illuminate\Support\Facades\Hash;

class TalentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $talents = [
            [
                'name' => 'Nguyễn Văn A',
                'email' => 'talent1@vietlance.com',
                'password' => Hash::make('password'),
                'phone' => '0912345678',
                'address' => 'Hà Nội, Việt Nam',
                'hourly_rate' => 25.00,
                'experience_years' => 5,
                'is_active' => true,
            ],
            [
                'name' => 'Trần Thị B',
                'email' => 'talent2@vietlance.com',
                'password' => Hash::make('password'),
                'phone' => '0923456789',
                'address' => 'TP. Hồ Chí Minh, Việt Nam',
                'hourly_rate' => 20.00,
                'experience_years' => 3,
                'is_active' => true,
            ],
            [
                'name' => 'Lê Văn C',
                'email' => 'talent3@vietlance.com',
                'password' => Hash::make('password'),
                'phone' => '0934567890',
                'address' => 'Đà Nẵng, Việt Nam',
                'hourly_rate' => 30.00,
                'experience_years' => 7,
                'is_active' => true,
            ],
        ];

        foreach ($talents as $talent) {
            Talent::firstOrCreate(
                ['email' => $talent['email']],
                $talent
            );
        }
    }
}




