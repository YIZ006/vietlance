-- Script SQL để thêm ngôn ngữ lập trình vào database
-- Chạy script này trong phpMyAdmin để thêm dữ liệu

USE `vietlance`;

-- Tạo bảng nếu chưa có
CREATE TABLE IF NOT EXISTS `programming_languages` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(100) NOT NULL,
    `category` VARCHAR(100) NOT NULL,
    `description` TEXT NULL DEFAULT NULL,
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    `updated_at` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `programming_languages_name_unique` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Xóa dữ liệu cũ (nếu cần)
-- DELETE FROM `programming_languages`;

-- Thêm dữ liệu ngôn ngữ lập trình
INSERT INTO `programming_languages` (`name`, `category`, `created_at`, `updated_at`) VALUES
-- 1. Ngôn ngữ lập trình chính
('Python', 'Ngôn ngữ lập trình chính', NOW(), NOW()),
('Java', 'Ngôn ngữ lập trình chính', NOW(), NOW()),
('C#', 'Ngôn ngữ lập trình chính', NOW(), NOW()),
('C++', 'Ngôn ngữ lập trình chính', NOW(), NOW()),
('C', 'Ngôn ngữ lập trình chính', NOW(), NOW()),
('PHP', 'Ngôn ngữ lập trình chính', NOW(), NOW()),
('TypeScript', 'Ngôn ngữ lập trình chính', NOW(), NOW()),
('Swift', 'Ngôn ngữ lập trình chính', NOW(), NOW()),
('Kotlin', 'Ngôn ngữ lập trình chính', NOW(), NOW()),
('Go (Golang)', 'Ngôn ngữ lập trình chính', NOW(), NOW()),
('Ruby', 'Ngôn ngữ lập trình chính', NOW(), NOW()),
('Dart (Flutter)', 'Ngôn ngữ lập trình chính', NOW(), NOW()),
('SQL', 'Ngôn ngữ lập trình chính', NOW(), NOW()),
('R', 'Ngôn ngữ lập trình chính', NOW(), NOW()),

-- 2. Web Development - Front-end
('JavaScript', 'Web Development - Front-end', NOW(), NOW()),
('HTML', 'Web Development - Front-end', NOW(), NOW()),
('CSS', 'Web Development - Front-end', NOW(), NOW()),
('SASS / SCSS', 'Web Development - Front-end', NOW(), NOW()),
('React.js', 'Web Development - Front-end', NOW(), NOW()),
('Angular', 'Web Development - Front-end', NOW(), NOW()),
('Vue.js', 'Web Development - Front-end', NOW(), NOW()),
('Svelte', 'Web Development - Front-end', NOW(), NOW()),
('Next.js', 'Web Development - Front-end', NOW(), NOW()),
('Nuxt.js', 'Web Development - Front-end', NOW(), NOW()),

-- 3. Web Development - Back-end
('Node.js', 'Web Development - Back-end', NOW(), NOW()),
('Perl', 'Web Development - Back-end', NOW(), NOW()),

-- 4. Mobile Development
('Swift (iOS)', 'Mobile Development', NOW(), NOW()),
('Kotlin (Android)', 'Mobile Development', NOW(), NOW()),
('Java (Android)', 'Mobile Development', NOW(), NOW()),
('React Native', 'Mobile Development', NOW(), NOW()),

-- 5. Game Development
('C# (Unity)', 'Game Development', NOW(), NOW()),
('C++ (Unreal Engine)', 'Game Development', NOW(), NOW()),
('Lua', 'Game Development', NOW(), NOW()),
('JavaScript (Web Game)', 'Game Development', NOW(), NOW()),
('GDScript (Godot)', 'Game Development', NOW(), NOW()),

-- 6. AI / Machine Learning / Data
('Julia', 'AI / Machine Learning / Data', NOW(), NOW()),
('Scala', 'AI / Machine Learning / Data', NOW(), NOW()),
('MATLAB', 'AI / Machine Learning / Data', NOW(), NOW()),
('SAS', 'AI / Machine Learning / Data', NOW(), NOW()),

-- 7. Hệ thống – nhúng – hiệu năng cao
('Rust', 'Hệ thống – nhúng – hiệu năng cao', NOW(), NOW()),
('Assembly', 'Hệ thống – nhúng – hiệu năng cao', NOW(), NOW()),
('Ada', 'Hệ thống – nhúng – hiệu năng cao', NOW(), NOW()),

-- 8. Cloud / DevOps
('Bash', 'Cloud / DevOps', NOW(), NOW()),
('PowerShell', 'Cloud / DevOps', NOW(), NOW()),

-- 9. Blockchain / Web3
('Solidity', 'Blockchain / Web3', NOW(), NOW()),
('Move (Aptos, Sui)', 'Blockchain / Web3', NOW(), NOW()),
('Vyper', 'Blockchain / Web3', NOW(), NOW()),

-- 10. Ngôn ngữ lập trình cũ
('COBOL', 'Ngôn ngữ lập trình cũ', NOW(), NOW()),
('Fortran', 'Ngôn ngữ lập trình cũ', NOW(), NOW()),
('Pascal', 'Ngôn ngữ lập trình cũ', NOW(), NOW()),
('Delphi', 'Ngôn ngữ lập trình cũ', NOW(), NOW()),
('Lisp', 'Ngôn ngữ lập trình cũ', NOW(), NOW()),
('Prolog', 'Ngôn ngữ lập trình cũ', NOW(), NOW()),

-- 11. Ngôn ngữ mới nổi
('Zig', 'Ngôn ngữ mới nổi', NOW(), NOW()),
('Crystal', 'Ngôn ngữ mới nổi', NOW(), NOW()),
('Elixir', 'Ngôn ngữ mới nổi', NOW(), NOW()),
('Nim', 'Ngôn ngữ mới nổi', NOW(), NOW());

