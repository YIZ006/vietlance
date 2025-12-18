# Hướng dẫn kết nối MySQL

## Bước 1: Tạo database trong MySQL

Mở MySQL (phpMyAdmin, MySQL Workbench, hoặc command line) và chạy:

```sql
CREATE DATABASE IF NOT EXISTS `vietlance` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

## Bước 2: Cấu hình file .env

Tạo hoặc cập nhật file `.env` trong thư mục `vietlance` với nội dung sau:

```env
APP_NAME=Laravel
APP_ENV=local
APP_KEY=base64:ZMncEG7/lIn9qIltSf+orQUSX60G+1kn66fncGr/6Ag=
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=vietlance
DB_USERNAME=root
DB_PASSWORD=

SESSION_DRIVER=database
SESSION_LIFETIME=120

BROADCAST_CONNECTION=log
FILESYSTEM_DISK=local
QUEUE_CONNECTION=database

CACHE_STORE=database
```

**Lưu ý:**
- `DB_PASSWORD`: Điền mật khẩu MySQL của bạn (nếu có)
- `DB_USERNAME`: Thường là `root`, nhưng có thể khác tùy cấu hình của bạn
- `DB_HOST`: Nếu MySQL chạy trên port khác, thay đổi `DB_PORT`

## Bước 3: Kiểm tra kết nối

Chạy lệnh sau để kiểm tra kết nối:

```bash
php artisan migrate:status
```

Nếu kết nối thành công, bạn sẽ thấy danh sách migrations.

## Bước 4: Chạy migrations và seeders

```bash
# Tạo các bảng
php artisan migrate

# Thêm dữ liệu mẫu
php artisan db:seed
```

## Xử lý lỗi thường gặp

### Lỗi: "Access denied for user"
- Kiểm tra lại `DB_USERNAME` và `DB_PASSWORD` trong file `.env`
- Đảm bảo MySQL đang chạy

### Lỗi: "Unknown database 'vietlance'"
- Chạy lại lệnh tạo database ở Bước 1

### Lỗi: "Connection refused"
- Kiểm tra MySQL có đang chạy không
- Kiểm tra `DB_HOST` và `DB_PORT` có đúng không

