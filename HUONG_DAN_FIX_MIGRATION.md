# Hướng dẫn sửa lỗi Migration

## Vấn đề
Migration bị lỗi vì cột `is_locked` đã tồn tại trong database.

## Giải pháp

### Cách 1: Xóa migration cũ và chạy lại (Khuyến nghị)

1. **Xóa migration không cần thiết:**
   - Đã xóa: `2025_12_11_101400_add_is_locked_to_admin_table.php` (không cần vì migration recreate đã có)

2. **Rollback migrations:**
   ```bash
   php artisan migrate:rollback --step=5
   ```

3. **Chạy lại migrations:**
   ```bash
   php artisan migrate
   ```

### Cách 2: Chạy SQL trực tiếp trong phpMyAdmin (Nhanh nhất)

1. Mở phpMyAdmin: `http://localhost/phpmyadmin`
2. Chọn database `vietlance`
3. Click tab **SQL**
4. Copy và chạy file `database/update_admin_table.sql`
5. Xong!

### Cách 3: Xóa bảng và chạy lại migration

```bash
# Vào MySQL
mysql -u root -p

# Xóa bảng admin
USE vietlance;
DROP TABLE IF EXISTS admin;

# Thoát MySQL và chạy migration
php artisan migrate
```

## Migration đã được cập nhật

Migration `2025_12_11_101402_recreate_admin_table_with_role.php` sẽ:
- Xóa bảng `admin` cũ
- Tạo lại với cấu trúc mới:
  - `admin_login` (thay vì `adminname`)
  - `role` ENUM('superadmin', 'admin', 'viewer')
  - `status` ENUM('active', 'inactive', 'locked')
  - Không có `is_active` và `is_locked`

## Lưu ý

⚠️ **QUAN TRỌNG**: 
- Migration recreate sẽ XÓA TẤT CẢ dữ liệu trong bảng `admin`
- Nếu có dữ liệu quan trọng, hãy backup trước!

