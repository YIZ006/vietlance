-- Script SQL để tạo database và thêm dữ liệu mẫu
-- Chạy script này nếu muốn thêm dữ liệu trực tiếp vào MySQL

-- Tạo database nếu chưa tồn tại
CREATE DATABASE IF NOT EXISTS `vietlance` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE `vietlance`;

-- Lưu ý: Các bảng sẽ được tạo tự động khi chạy migrations
-- File này chỉ để tham khảo

-- Sau khi chạy migrations, bạn có thể chạy các câu lệnh INSERT sau:

-- Thêm Admin (chỉ chạy nếu bảng admin đã được tạo với cấu trúc mới)
INSERT INTO `admin` (`name`, `admin_login`, `email`, `password`, `phone`, `address`, `role`, `status`, `created_at`, `updated_at`) VALUES
('Super Admin', 'superadmin', 'superadmin@vietlance.com', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '0987654321', 'TP. Hồ Chí Minh, Việt Nam', 'superadmin', 'active', NOW(), NOW()),
('Admin', 'admin', 'admin@vietlance.com', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '0123456789', 'Hà Nội, Việt Nam', 'admin', 'active', NOW(), NOW()),
('Viewer', 'viewer', 'viewer@vietlance.com', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '0123456780', 'Đà Nẵng, Việt Nam', 'viewer', 'active', NOW(), NOW());

-- Thêm Freelance
INSERT INTO `freelance` (`name`, `email`, `password`, `phone`, `address`, `bio`, `skills`, `hourly_rate`, `experience_years`, `is_active`, `created_at`, `updated_at`) VALUES
('Nguyễn Văn A', 'freelance1@vietlance.com', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '0912345678', 'Hà Nội, Việt Nam', 'Full-stack developer với 5 năm kinh nghiệm', 'PHP, Laravel, JavaScript, Vue.js, MySQL', 25.00, 5, 1, NOW(), NOW()),
('Trần Thị B', 'freelance2@vietlance.com', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '0923456789', 'TP. Hồ Chí Minh, Việt Nam', 'UI/UX Designer chuyên nghiệp', 'Figma, Adobe XD, Photoshop, Illustrator', 20.00, 3, 1, NOW(), NOW());

-- Thêm Client
INSERT INTO `client` (`name`, `email`, `password`, `phone`, `address`, `company_name`, `company_description`, `is_active`, `created_at`, `updated_at`) VALUES
('Công ty ABC', 'client1@vietlance.com', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '0934567890', 'Hà Nội, Việt Nam', 'Công ty TNHH ABC', 'Công ty chuyên về công nghệ thông tin', 1, NOW(), NOW()),
('Công ty XYZ', 'client2@vietlance.com', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '0945678901', 'TP. Hồ Chí Minh, Việt Nam', 'Công ty Cổ phần XYZ', 'Công ty chuyên về thương mại điện tử', 1, NOW(), NOW());

-- Lưu ý: Password mặc định là "password" (đã được hash bằng bcrypt)
-- Bạn nên đổi password sau khi đăng nhập lần đầu

