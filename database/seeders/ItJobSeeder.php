<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ItJobSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Lấy category_id từ database
        $categories = DB::table('job_categories')->pluck('category_id', 'category_name')->toArray();

        $jobs = [
            // 1. Lập trình & Phát triển phần mềm
            ['category_name' => 'Lập trình & Phát triển phần mềm', 'jobs' => [
                'Software Developer',
                'Front-end Developer',
                'Back-end Developer',
                'Full-stack Developer',
                'Mobile Developer (Android / iOS / Flutter / React Native)',
                'Game Developer (Unity / Unreal / Web Game)',
                'Desktop App Developer (C#, Java, Python…)',
                'API Developer',
                'Automation Developer (Python, RPA…)',
                'WordPress Developer',
                'Shopify Developer',
                'Webflow Developer',
                'Plugin Developer',
                'Theme Developer',
                'Embedded Software Engineer',
                'Firmware Developer',
            ]],
            
            // 2. Khoa học dữ liệu & Trí tuệ nhân tạo
            ['category_name' => 'Khoa học dữ liệu & Trí tuệ nhân tạo', 'jobs' => [
                'Data Scientist',
                'Machine Learning Engineer',
                'Deep Learning Engineer',
                'AI Engineer',
                'NLP Engineer',
                'Computer Vision Engineer',
                'Data Analyst',
                'Business Intelligence Analyst',
                'Data Engineer',
                'MLOps Engineer',
            ]],
            
            // 3. DevOps & Cloud
            ['category_name' => 'DevOps & Cloud', 'jobs' => [
                'DevOps Engineer',
                'Cloud Engineer (AWS / Azure / GCP)',
                'Cloud Architect',
                'Site Reliability Engineer (SRE)',
                'CI/CD Engineer',
                'Infrastructure Engineer',
                'Kubernetes Specialist',
                'Docker Specialist',
            ]],
            
            // 4. An toàn thông tin (Cyber Security)
            ['category_name' => 'An toàn thông tin (Cyber Security)', 'jobs' => [
                'Cyber Security Analyst',
                'Penetration Tester (Pentester)',
                'Ethical Hacker',
                'SOC Analyst',
                'Security Engineer',
                'Application Security Engineer',
                'Network Security Engineer',
                'Incident Response Specialist',
                'Malware Analyst',
                'Threat Hunter',
                'Digital Forensics Analyst',
                'Vulnerability Management Specialist',
                'Red Team / Blue Team Specialist',
            ]],
            
            // 5. Quản trị hệ thống & mạng
            ['category_name' => 'Quản trị hệ thống & mạng', 'jobs' => [
                'System Administrator',
                'Network Administrator',
                'Windows Server Admin',
                'Linux Administrator',
                'Database Administrator (DBA)',
                'IT Support / Helpdesk',
                'Network Engineer',
                'Virtualization Engineer (VMware, Hyper-V)',
            ]],
            
            // 6. Thiết kế & Sáng tạo công nghệ
            ['category_name' => 'Thiết kế & Sáng tạo công nghệ', 'jobs' => [
                'UI/UX Designer',
                'Product Designer',
                'Graphic Designer',
                'Motion Designer',
                '3D Modeler (Blender, Maya, 3ds Max)',
                'Video Editor',
                'Game Artist',
                'VFX Artist',
            ]],
            
            // 7. Quản lý dự án & phân tích nghiệp vụ
            ['category_name' => 'Quản lý dự án & phân tích nghiệp vụ', 'jobs' => [
                'Project Manager (IT PM)',
                'Scrum Master',
                'Product Manager',
                'Product Owner',
                'Business Analyst',
                'Technical Writer',
            ]],
            
            // 8. Kiểm thử & Đảm bảo chất lượng
            ['category_name' => 'Kiểm thử & Đảm bảo chất lượng', 'jobs' => [
                'QA Engineer',
                'Manual Tester',
                'Automation Tester (Selenium, Cypress…)',
                'Performance Tester',
                'Test Lead / Test Manager',
            ]],
            
            // 9. Web, Hosting & Hạ tầng Internet
            ['category_name' => 'Web, Hosting & Hạ tầng Internet', 'jobs' => [
                'Web Admin',
                'Hosting Engineer',
                'Domain Specialist',
                'Email Server Specialist',
                'CDN / DNS Specialist',
            ]],
            
            // 10. Blockchain & Công nghệ Web3
            ['category_name' => 'Blockchain & Công nghệ Web3', 'jobs' => [
                'Blockchain Developer',
                'Smart Contract Developer (Solidity, Rust)',
                'Web3 Developer',
                'Crypto Security Expert',
                'NFT Project Developer',
            ]],
            
            // 11. Phần cứng, IoT & điện tử
            ['category_name' => 'Phần cứng, IoT & điện tử', 'jobs' => [
                'IoT Developer',
                'Hardware Engineer',
                'PCB Designer',
                'Robotics Engineer',
                'Embedded Systems Engineer',
            ]],
            
            // 12. Sales & Support kỹ thuật
            ['category_name' => 'Sales & Support kỹ thuật', 'jobs' => [
                'Technical Support',
                'Technical Consultant',
                'Pre-sale Engineer',
                'Customer Success (Tech)',
            ]],
            
            // 13. Nội dung kỹ thuật
            ['category_name' => 'Nội dung kỹ thuật', 'jobs' => [
                'Technical Content Writer',
                'Tech Blogger',
                'Documentation Specialist',
                'IT Trainer',
            ]],
        ];

        foreach ($jobs as $categoryData) {
            $categoryId = $categories[$categoryData['category_name']] ?? null;
            
            if ($categoryId) {
                foreach ($categoryData['jobs'] as $jobTitle) {
                    DB::table('it_jobs')->insertOrIgnore([
                        'job_title' => $jobTitle,
                        'category_id' => $categoryId,
                        'short_description' => null,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }
    }
}

