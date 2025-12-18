-- Script SQL để cập nhật bảng admin
-- Chạy script này trong phpMyAdmin để cập nhật cấu trúc bảng

USE `vietlance`;

-- Xóa bảng admin cũ
DROP TABLE IF EXISTS `admin`;

-- Tạo lại bảng admin với cấu trúc mới
CREATE TABLE `admin` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(255) NOT NULL,
    `admin_login` VARCHAR(255) NULL UNIQUE,
    `email` VARCHAR(255) NOT NULL UNIQUE,
    `email_verified_at` TIMESTAMP NULL DEFAULT NULL,
    `password` VARCHAR(255) NOT NULL,
    `phone` VARCHAR(255) NULL DEFAULT NULL,
    `address` TEXT NULL DEFAULT NULL,
    `avatar` VARCHAR(255) NULL DEFAULT NULL,
    `role` ENUM('superadmin', 'admin', 'viewer') NOT NULL DEFAULT 'admin',
    `status` ENUM('active', 'inactive', 'locked') NOT NULL DEFAULT 'active',
    `remember_token` VARCHAR(100) NULL DEFAULT NULL,
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    `updated_at` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `admin_admin_login_unique` (`admin_login`),
    UNIQUE KEY `admin_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Thêm dữ liệu mẫu
INSERT INTO `admin` (`name`, `admin_login`, `email`, `password`, `phone`, `address`, `role`, `status`, `created_at`, `updated_at`) VALUES
('Super Admin', 'superadmin', 'superadmin@vietlance.com', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '0987654321', 'TP. Hồ Chí Minh, Việt Nam', 'superadmin', 'active', NOW(), NOW()),
('Admin', 'admin', 'admin@vietlance.com', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '0123456789', 'Hà Nội, Việt Nam', 'admin', 'active', NOW(), NOW()),
('Viewer', 'viewer', 'viewer@vietlance.com', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '0123456780', 'Đà Nẵng, Việt Nam', 'viewer', 'active', NOW(), NOW());

-- Lưu ý: Password mặc định là "password" (đã được hash bằng bcrypt)
-- Bạn nên đổi password sau khi đăng nhập lần đầu

