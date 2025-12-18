<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Tạo Super Admin (nếu chưa tồn tại)
        Admin::firstOrCreate(
            ['email' => 'superadmin@vietlance.com'],
            [
                'name' => 'Super Admin',
                'admin_login' => 'superadmin',
                'password' => Hash::make('password'),
                'phone' => '0987654321',
                'address' => 'TP. Hồ Chí Minh, Việt Nam',
                'role' => 'superadmin',
                'status' => 'active',
            ]
        );

        // Tạo Admin (nếu chưa tồn tại)
        Admin::firstOrCreate(
            ['email' => 'admin@vietlance.com'],
            [
                'name' => 'Admin',
                'admin_login' => 'admin',
                'password' => Hash::make('password'),
                'phone' => '0123456789',
                'address' => 'Hà Nội, Việt Nam',
                'role' => 'admin',
                'status' => 'active',
            ]
        );

        // Tạo Viewer (nếu chưa tồn tại)
        Admin::firstOrCreate(
            ['email' => 'viewer@vietlance.com'],
            [
                'name' => 'Viewer',
                'admin_login' => 'viewer',
                'password' => Hash::make('password'),
                'phone' => '0123456780',
                'address' => 'Đà Nẵng, Việt Nam',
                'role' => 'viewer',
                'status' => 'active',
            ]
        );
    }
}

