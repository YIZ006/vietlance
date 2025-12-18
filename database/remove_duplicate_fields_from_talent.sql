-- Script SQL để xóa các trường trùng lặp trong bảng talent
-- Các trường này đã có trong bảng profiles nên không cần trong talent
-- Chạy script này trong phpMyAdmin

USE `vietlance`;

-- Xóa cột bio (đã có profile_overview trong profiles)
ALTER TABLE `talent` DROP COLUMN IF EXISTS `bio`;

-- Xóa cột skills (đã có skills trong profiles dạng JSON)
ALTER TABLE `talent` DROP COLUMN IF EXISTS `skills`;

-- Kiểm tra kết quả
DESCRIBE `talent`;

