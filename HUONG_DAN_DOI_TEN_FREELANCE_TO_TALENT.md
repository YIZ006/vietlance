# Hướng dẫn đổi tên bảng freelance thành talent trong database

## Cách 1: Sử dụng Migration (Khuyến nghị)

### Bước 1: Chạy migrations
```bash
cd "E:\tài liệu\Môn Project2_php_lavarel\vietlance"
php artisan migrate
```

Migration sẽ tự động:
- Đổi tên bảng `freelance` → `talent` (nếu bảng `freelance` tồn tại)
- Hoặc tạo bảng `talent` mới (nếu bảng `freelance` chưa tồn tại)
- Cập nhật `magic_links` user_type từ `freelance` → `talent`
- Thêm các cột GitHub nếu chưa có

## Cách 2: Chạy SQL trực tiếp trong phpMyAdmin

### Bước 1: Mở phpMyAdmin
1. Truy cập `http://localhost/phpmyadmin`
2. Chọn database `vietlance`

### Bước 2: Chạy SQL script
Copy và chạy script sau trong tab SQL:

```sql
USE `vietlance`;

-- Đổi tên bảng freelance thành talent
RENAME TABLE `freelance` TO `talent`;

-- Cập nhật magic_links table
UPDATE `magic_links` SET `user_type` = 'talent' WHERE `user_type` = 'freelance';

-- Kiểm tra kết quả
SELECT COUNT(*) AS total_talents FROM `talent`;
```

### Bước 3: Kiểm tra kết quả
Sau khi chạy SQL, kiểm tra:
- Bảng `talent` đã được tạo/đổi tên thành công
- Dữ liệu trong bảng `talent` vẫn còn nguyên
- Bảng `magic_links` đã được cập nhật

## Cách 3: Nếu bảng đã tồn tại và có dữ liệu

Nếu bạn muốn giữ nguyên dữ liệu và chỉ đổi tên:

```sql
USE `vietlance`;

-- Tạo bảng talent từ cấu trúc của freelance
CREATE TABLE `talent` LIKE `freelance`;

-- Copy dữ liệu từ freelance sang talent
INSERT INTO `talent` SELECT * FROM `freelance`;

-- Xóa bảng freelance cũ
DROP TABLE `freelance`;

-- Cập nhật magic_links
UPDATE `magic_links` SET `user_type` = 'talent' WHERE `user_type` = 'freelance';
```

## Kiểm tra sau khi đổi tên

### Kiểm tra trong phpMyAdmin:
1. Mở database `vietlance`
2. Kiểm tra bảng `talent` đã tồn tại
3. Kiểm tra bảng `freelance` đã không còn (hoặc đã được đổi tên)
4. Kiểm tra bảng `magic_links` có user_type = 'talent'

### Kiểm tra bằng Laravel:
```bash
php artisan tinker
```

Trong tinker:
```php
// Kiểm tra bảng talent
\App\Models\Talent::count();

// Kiểm tra magic links
\App\Models\MagicLink::where('user_type', 'talent')->count();
```

## Lưu ý quan trọng

1. **Backup database trước khi thực hiện**: Luôn backup database trước khi đổi tên bảng
2. **Kiểm tra foreign keys**: Nếu có bảng khác tham chiếu đến bảng `freelance`, cần cập nhật foreign keys
3. **Chạy migrations theo thứ tự**: Đảm bảo migrations được chạy theo đúng thứ tự thời gian

## Troubleshooting

### Lỗi: Table 'freelance' doesn't exist
- **Nguyên nhân**: Bảng đã được đổi tên hoặc chưa được tạo
- **Giải pháp**: Chạy migration tạo bảng `talent` mới hoặc kiểm tra xem bảng `talent` đã tồn tại chưa

### Lỗi: Duplicate entry for key
- **Nguyên nhân**: Đã có dữ liệu trong bảng `talent`
- **Giải pháp**: Xóa dữ liệu cũ hoặc merge dữ liệu từ `freelance` sang `talent`

### Lỗi: Cannot change enum value
- **Nguyên nhân**: MySQL không cho phép thay đổi enum trực tiếp
- **Giải pháp**: Sử dụng migration `update_magic_links_user_type` để cập nhật enum

## Sau khi đổi tên thành công

1. Chạy seeder để thêm dữ liệu mẫu:
```bash
php artisan db:seed --class=TalentSeeder
```

2. Kiểm tra ứng dụng hoạt động bình thường:
- Đăng nhập talent
- Đăng ký talent mới
- Quản lý talent trong admin panel

