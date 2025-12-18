-- Script SQL để thêm đầy đủ dữ liệu công việc IT
-- Chạy sau khi đã chạy create_job_tables.sql và có dữ liệu trong job_categories

USE `vietlance`;

-- Lấy category_id (giả sử category_id bắt đầu từ 1)
-- 1. Lập trình & Phát triển phần mềm
INSERT INTO `it_jobs` (`job_title`, `category_id`, `created_at`, `updated_at`) VALUES
('Software Developer', 1, NOW(), NOW()),
('Front-end Developer', 1, NOW(), NOW()),
('Back-end Developer', 1, NOW(), NOW()),
('Full-stack Developer', 1, NOW(), NOW()),
('Mobile Developer (Android / iOS / Flutter / React Native)', 1, NOW(), NOW()),
('Game Developer (Unity / Unreal / Web Game)', 1, NOW(), NOW()),
('Desktop App Developer (C#, Java, Python…)', 1, NOW(), NOW()),
('API Developer', 1, NOW(), NOW()),
('Automation Developer (Python, RPA…)', 1, NOW(), NOW()),
('WordPress Developer', 1, NOW(), NOW()),
('Shopify Developer', 1, NOW(), NOW()),
('Webflow Developer', 1, NOW(), NOW()),
('Plugin Developer', 1, NOW(), NOW()),
('Theme Developer', 1, NOW(), NOW()),
('Embedded Software Engineer', 1, NOW(), NOW()),
('Firmware Developer', 1, NOW(), NOW());

-- 2. Khoa học dữ liệu & Trí tuệ nhân tạo
INSERT INTO `it_jobs` (`job_title`, `category_id`, `created_at`, `updated_at`) VALUES
('Data Scientist', 2, NOW(), NOW()),
('Machine Learning Engineer', 2, NOW(), NOW()),
('Deep Learning Engineer', 2, NOW(), NOW()),
('AI Engineer', 2, NOW(), NOW()),
('NLP Engineer', 2, NOW(), NOW()),
('Computer Vision Engineer', 2, NOW(), NOW()),
('Data Analyst', 2, NOW(), NOW()),
('Business Intelligence Analyst', 2, NOW(), NOW()),
('Data Engineer', 2, NOW(), NOW()),
('MLOps Engineer', 2, NOW(), NOW());

-- 3. DevOps & Cloud
INSERT INTO `it_jobs` (`job_title`, `category_id`, `created_at`, `updated_at`) VALUES
('DevOps Engineer', 3, NOW(), NOW()),
('Cloud Engineer (AWS / Azure / GCP)', 3, NOW(), NOW()),
('Cloud Architect', 3, NOW(), NOW()),
('Site Reliability Engineer (SRE)', 3, NOW(), NOW()),
('CI/CD Engineer', 3, NOW(), NOW()),
('Infrastructure Engineer', 3, NOW(), NOW()),
('Kubernetes Specialist', 3, NOW(), NOW()),
('Docker Specialist', 3, NOW(), NOW());

-- 4. An toàn thông tin (Cyber Security)
INSERT INTO `it_jobs` (`job_title`, `category_id`, `created_at`, `updated_at`) VALUES
('Cyber Security Analyst', 4, NOW(), NOW()),
('Penetration Tester (Pentester)', 4, NOW(), NOW()),
('Ethical Hacker', 4, NOW(), NOW()),
('SOC Analyst', 4, NOW(), NOW()),
('Security Engineer', 4, NOW(), NOW()),
('Application Security Engineer', 4, NOW(), NOW()),
('Network Security Engineer', 4, NOW(), NOW()),
('Incident Response Specialist', 4, NOW(), NOW()),
('Malware Analyst', 4, NOW(), NOW()),
('Threat Hunter', 4, NOW(), NOW()),
('Digital Forensics Analyst', 4, NOW(), NOW()),
('Vulnerability Management Specialist', 4, NOW(), NOW()),
('Red Team / Blue Team Specialist', 4, NOW(), NOW());

-- 5. Quản trị hệ thống & mạng
INSERT INTO `it_jobs` (`job_title`, `category_id`, `created_at`, `updated_at`) VALUES
('System Administrator', 5, NOW(), NOW()),
('Network Administrator', 5, NOW(), NOW()),
('Windows Server Admin', 5, NOW(), NOW()),
('Linux Administrator', 5, NOW(), NOW()),
('Database Administrator (DBA)', 5, NOW(), NOW()),
('IT Support / Helpdesk', 5, NOW(), NOW()),
('Network Engineer', 5, NOW(), NOW()),
('Virtualization Engineer (VMware, Hyper-V)', 5, NOW(), NOW());

-- 6. Thiết kế & Sáng tạo công nghệ
INSERT INTO `it_jobs` (`job_title`, `category_id`, `created_at`, `updated_at`) VALUES
('UI/UX Designer', 6, NOW(), NOW()),
('Product Designer', 6, NOW(), NOW()),
('Graphic Designer', 6, NOW(), NOW()),
('Motion Designer', 6, NOW(), NOW()),
('3D Modeler (Blender, Maya, 3ds Max)', 6, NOW(), NOW()),
('Video Editor', 6, NOW(), NOW()),
('Game Artist', 6, NOW(), NOW()),
('VFX Artist', 6, NOW(), NOW());

-- 7. Quản lý dự án & phân tích nghiệp vụ
INSERT INTO `it_jobs` (`job_title`, `category_id`, `created_at`, `updated_at`) VALUES
('Project Manager (IT PM)', 7, NOW(), NOW()),
('Scrum Master', 7, NOW(), NOW()),
('Product Manager', 7, NOW(), NOW()),
('Product Owner', 7, NOW(), NOW()),
('Business Analyst', 7, NOW(), NOW()),
('Technical Writer', 7, NOW(), NOW());

-- 8. Kiểm thử & Đảm bảo chất lượng
INSERT INTO `it_jobs` (`job_title`, `category_id`, `created_at`, `updated_at`) VALUES
('QA Engineer', 8, NOW(), NOW()),
('Manual Tester', 8, NOW(), NOW()),
('Automation Tester (Selenium, Cypress…)', 8, NOW(), NOW()),
('Performance Tester', 8, NOW(), NOW()),
('Test Lead / Test Manager', 8, NOW(), NOW());

-- 9. Web, Hosting & Hạ tầng Internet
INSERT INTO `it_jobs` (`job_title`, `category_id`, `created_at`, `updated_at`) VALUES
('Web Admin', 9, NOW(), NOW()),
('Hosting Engineer', 9, NOW(), NOW()),
('Domain Specialist', 9, NOW(), NOW()),
('Email Server Specialist', 9, NOW(), NOW()),
('CDN / DNS Specialist', 9, NOW(), NOW());

-- 10. Blockchain & Công nghệ Web3
INSERT INTO `it_jobs` (`job_title`, `category_id`, `created_at`, `updated_at`) VALUES
('Blockchain Developer', 10, NOW(), NOW()),
('Smart Contract Developer (Solidity, Rust)', 10, NOW(), NOW()),
('Web3 Developer', 10, NOW(), NOW()),
('Crypto Security Expert', 10, NOW(), NOW()),
('NFT Project Developer', 10, NOW(), NOW());

-- 11. Phần cứng, IoT & điện tử
INSERT INTO `it_jobs` (`job_title`, `category_id`, `created_at`, `updated_at`) VALUES
('IoT Developer', 11, NOW(), NOW()),
('Hardware Engineer', 11, NOW(), NOW()),
('PCB Designer', 11, NOW(), NOW()),
('Robotics Engineer', 11, NOW(), NOW()),
('Embedded Systems Engineer', 11, NOW(), NOW());

-- 12. Sales & Support kỹ thuật
INSERT INTO `it_jobs` (`job_title`, `category_id`, `created_at`, `updated_at`) VALUES
('Technical Support', 12, NOW(), NOW()),
('Technical Consultant', 12, NOW(), NOW()),
('Pre-sale Engineer', 12, NOW(), NOW()),
('Customer Success (Tech)', 12, NOW(), NOW());

-- 13. Nội dung kỹ thuật
INSERT INTO `it_jobs` (`job_title`, `category_id`, `created_at`, `updated_at`) VALUES
('Technical Content Writer', 13, NOW(), NOW()),
('Tech Blogger', 13, NOW(), NOW()),
('Documentation Specialist', 13, NOW(), NOW()),
('IT Trainer', 13, NOW(), NOW());

