-- Script SQL để tạo bảng job_categories và it_jobs
-- Chạy script này trong phpMyAdmin để tạo bảng và thêm dữ liệu

USE `vietlance`;

-- Tạo bảng job_categories
CREATE TABLE IF NOT EXISTS `job_categories` (
    `category_id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `category_name` VARCHAR(200) NOT NULL,
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    `updated_at` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tạo bảng it_jobs
CREATE TABLE IF NOT EXISTS `it_jobs` (
    `job_id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `job_title` VARCHAR(255) NOT NULL,
    `category_id` BIGINT UNSIGNED NULL DEFAULT NULL,
    `short_description` TEXT NULL DEFAULT NULL,
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    `updated_at` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`job_id`),
    KEY `it_jobs_category_id_foreign` (`category_id`),
    CONSTRAINT `it_jobs_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `job_categories` (`category_id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Thêm dữ liệu danh mục
INSERT INTO `job_categories` (`category_name`, `created_at`, `updated_at`) VALUES
('Lập trình & Phát triển phần mềm', NOW(), NOW()),
('Khoa học dữ liệu & Trí tuệ nhân tạo', NOW(), NOW()),
('DevOps & Cloud', NOW(), NOW()),
('An toàn thông tin (Cyber Security)', NOW(), NOW()),
('Quản trị hệ thống & mạng', NOW(), NOW()),
('Thiết kế & Sáng tạo công nghệ', NOW(), NOW()),
('Quản lý dự án & phân tích nghiệp vụ', NOW(), NOW()),
('Kiểm thử & Đảm bảo chất lượng', NOW(), NOW()),
('Web, Hosting & Hạ tầng Internet', NOW(), NOW()),
('Blockchain & Công nghệ Web3', NOW(), NOW()),
('Phần cứng, IoT & điện tử', NOW(), NOW()),
('Sales & Support kỹ thuật', NOW(), NOW()),
('Nội dung kỹ thuật', NOW(), NOW());

-- Thêm dữ liệu công việc (sẽ được thêm sau khi có category_id)

