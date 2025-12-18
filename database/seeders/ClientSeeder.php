<?php

namespace Database\Seeders;

use App\Models\Client;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Tạo Client 1 (nếu chưa tồn tại)
        Client::firstOrCreate(
            ['email' => 'client1@vietlance.com'],
            [
                'name' => 'Công ty ABC',
                'password' => Hash::make('password'),
                'phone' => '0934567890',
                'address' => 'Hà Nội, Việt Nam',
                'company_name' => 'Công ty TNHH ABC',
                'company_description' => 'Công ty chuyên về công nghệ thông tin',
                'is_active' => true,
            ]
        );

        // Tạo Client 2 (nếu chưa tồn tại)
        Client::firstOrCreate(
            ['email' => 'client2@vietlance.com'],
            [
                'name' => 'Công ty XYZ',
                'password' => Hash::make('password'),
                'phone' => '0945678901',
                'address' => 'TP. Hồ Chí Minh, Việt Nam',
                'company_name' => 'Công ty Cổ phần XYZ',
                'company_description' => 'Công ty chuyên về thương mại điện tử',
                'is_active' => true,
            ]
        );
    }
}

