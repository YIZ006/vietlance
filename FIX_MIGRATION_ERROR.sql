-- Script SQL để sửa lỗi migration
-- Chạy script này trong phpMyAdmin để xóa bảng admin và chạy lại migration

USE `vietlance`;

-- Xóa bảng admin cũ (nếu có)
DROP TABLE IF EXISTS `admin`;

-- Sau khi chạy script này, chạy lại: php artisan migrate

