-- Script SQL để đổi tên bảng freelance thành talent
-- Chạy script này trong phpMyAdmin để đổi tên bảng

USE `vietlance`;

-- Kiểm tra và đổi tên bảng nếu tồn tại
-- Nếu bảng freelance tồn tại, đổi tên thành talent
RENAME TABLE `freelance` TO `talent`;

-- Hoặc nếu bạn muốn tạo mới bảng talent từ bảng freelance (giữ nguyên dữ liệu)
-- CREATE TABLE `talent` LIKE `freelance`;
-- INSERT INTO `talent` SELECT * FROM `freelance`;
-- DROP TABLE `freelance`;

-- Cập nhật magic_links table để đổi user_type từ 'freelance' thành 'talent'
UPDATE `magic_links` SET `user_type` = 'talent' WHERE `user_type` = 'freelance';

-- Kiểm tra kết quả
SELECT 'Bảng đã được đổi tên thành công!' AS message;
SELECT COUNT(*) AS total_talents FROM `talent`;

