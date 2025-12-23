# Hướng dẫn Fix lỗi 502 Bad Gateway trên Railway

## Nguyên nhân phổ biến của lỗi 502

Lỗi **502 Bad Gateway** trên Railway thường xảy ra khi:
1. Ứng dụng không listen đúng port mà Railway mong đợi
2. Ứng dụng chỉ listen trên `localhost` thay vì `0.0.0.0`
3. Ứng dụng crash hoặc không start được
4. Thiếu biến môi trường quan trọng (APP_KEY, DB_*, etc.)
5. Lỗi trong Laravel bootstrap hoặc database connection

---

## Các bước kiểm tra và fix

### 1. Kiểm tra Deploy Logs

Vào Railway Dashboard → Service "vietlance" → Tab **"Deploy Logs"**

**Tìm các dòng:**
- ✅ `Starting PHP built-in server on 0.0.0.0:8080` - OK
- ✅ `PHP 8.2.30 Development Server (http://0.0.0.0:8080) started` - OK
- ❌ `ERROR:` hoặc `FATAL:` - Có lỗi cần fix

**Nếu thấy lỗi:**
- `ERROR: bootstrap/app.php not found!` → Kiểm tra cấu trúc thư mục
- `ERROR: public/index.php has syntax errors!` → Fix lỗi syntax PHP
- `Database connection: FAILED` → Kiểm tra biến môi trường DB_*

---

### 2. Kiểm tra Environment Variables

Vào Railway Dashboard → Service "vietlance" → Tab **"Variables"**

**Đảm bảo có các biến sau:**

#### Bắt buộc:
```bash
APP_NAME=Vietlance
APP_ENV=production
APP_KEY=base64:YOUR_APP_KEY_HERE  # ⚠️ QUAN TRỌNG!
APP_DEBUG=false
APP_URL=https://vietlance-production.up.railway.app

# Database
DB_CONNECTION=mysql
DB_HOST=${{MySQL.MYSQLHOST}}  # Hoặc host cụ thể
DB_PORT=${{MySQL.MYSQLPORT}}  # Hoặc port cụ thể
DB_DATABASE=${{MySQL.MYSQLDATABASE}}
DB_USERNAME=${{MySQL.MYSQLUSER}}
DB_PASSWORD=${{MySQL.MYSQLPASSWORD}}

# Session
SESSION_DRIVER=file
SESSION_SECRET=your-secret-key-here
```

#### Tùy chọn (nhưng nên có):
```bash
HOST=0.0.0.0  # Đảm bảo bind trên 0.0.0.0
PORT=8080     # Railway tự động set, nhưng có thể set thủ công
```

**Lưu ý quan trọng:**
- `APP_KEY` phải được set! Nếu thiếu, Laravel sẽ không hoạt động.
- `HOST=0.0.0.0` là bắt buộc để Railway có thể kết nối từ bên ngoài.

---

### 3. Kiểm tra Port Configuration

**Railway tự động set `PORT` environment variable.** Ứng dụng đã được cấu hình để:
- Đọc `PORT` từ environment variable
- Bind trên `0.0.0.0:$PORT` (không phải `localhost`)
- Sử dụng `start-server.sh` để start server

**Nếu muốn set PORT thủ công:**
1. Vào Variables → Thêm `PORT=8080`
2. Redeploy service

**Nhưng thường KHÔNG CẦN** vì Railway tự động quản lý.

---

### 4. Kiểm tra Database Connection

Lỗi 502 có thể do database không kết nối được.

**Kiểm tra:**
1. MySQL service có "Online" không?
2. Các biến `DB_*` đã được set đúng chưa?
3. Database đã được tạo chưa?

**Test connection:**
Vào Railway Dashboard → Service "vietlance" → Tab "Deploy Logs"
Tìm dòng: `Database connection: OK` hoặc `Database connection: FAILED`

---

### 5. Kiểm tra Laravel Bootstrap

**Các file cần thiết:**
- ✅ `bootstrap/app.php` - Laravel bootstrap file
- ✅ `public/index.php` - Entry point
- ✅ `.env` - Environment configuration
- ✅ `vendor/` - Composer dependencies

**Nếu thiếu:**
- Chạy `composer install` trong build process
- Đảm bảo `.env` được tạo từ `.env.example`

---

### 6. Kiểm tra Permissions

Storage và cache directories phải có quyền ghi:

```bash
chmod -R 775 storage bootstrap/cache
```

Script `start-server.sh` đã tự động set permissions, nhưng nếu vẫn lỗi, có thể cần check lại.

---

## Các bước fix cụ thể

### Fix 1: Thiếu APP_KEY

1. Vào Railway Dashboard → Variables
2. Thêm hoặc update:
   ```bash
   APP_KEY=base64:YOUR_APP_KEY_HERE
   ```
3. Để generate key mới:
   ```bash
   # Trên local machine:
   php artisan key:generate --show
   # Copy output và paste vào Railway Variables
   ```
4. Redeploy service

### Fix 2: Database Connection Failed

1. Kiểm tra MySQL service đang "Online"
2. Kiểm tra các biến DB_*:
   ```bash
   DB_HOST=${{MySQL.MYSQLHOST}}
   DB_PORT=${{MySQL.MYSQLPORT}}
   DB_DATABASE=${{MySQL.MYSQLDATABASE}}
   DB_USERNAME=${{MySQL.MYSQLUSER}}
   DB_PASSWORD=${{MySQL.MYSQLPASSWORD}}
   ```
3. Hoặc set thủ công nếu không dùng Railway MySQL:
   ```bash
   DB_HOST=your-db-host
   DB_PORT=3306
   DB_DATABASE=your-database
   DB_USERNAME=your-username
   DB_PASSWORD=your-password
   ```
4. Redeploy service

### Fix 3: Ứng dụng không listen đúng port

1. Kiểm tra `HOST=0.0.0.0` trong Variables
2. Kiểm tra Deploy Logs có dòng:
   ```
   Starting PHP built-in server on 0.0.0.0:8080
   ```
3. Nếu không thấy, có thể script không chạy đúng
4. Redeploy và kiểm tra lại

### Fix 4: Laravel Bootstrap Error

1. Kiểm tra Deploy Logs có lỗi syntax
2. Kiểm tra `bootstrap/app.php` và `public/index.php` có tồn tại
3. Kiểm tra Composer dependencies đã được install chưa
4. Redeploy service

---

## Debug Commands (nếu có Railway CLI)

```bash
# Xem logs real-time
railway logs

# Chạy artisan commands
railway run php artisan --version
railway run php artisan config:clear
railway run php artisan cache:clear

# Test database connection
railway run php artisan tinker
# Trong tinker:
DB::connection()->getPdo();
```

---

## Checklist trước khi deploy

- [ ] Tất cả biến môi trường đã được set (đặc biệt là `APP_KEY`)
- [ ] `HOST=0.0.0.0` đã được set
- [ ] Database connection variables đã được set đúng
- [ ] MySQL service đang "Online"
- [ ] `.env` file sẽ được tạo từ `.env.example` (hoặc đã có sẵn)
- [ ] `start-server.sh` có quyền execute (`chmod +x`)
- [ ] Composer dependencies sẽ được install trong build

---

## Sau khi fix

1. **Redeploy service:**
   - Vào Deployments tab
   - Click "Redeploy" hoặc push code mới lên GitHub

2. **Kiểm tra Deploy Logs:**
   - Đảm bảo không có ERROR
   - Tìm dòng: `PHP Development Server started`

3. **Kiểm tra HTTP Logs:**
   - Request đến `/` phải trả về 200 (không phải 502)
   - Nếu vẫn 502, kiểm tra lại các bước trên

---

## Liên hệ hỗ trợ

Nếu vẫn gặp lỗi sau khi thử các bước trên:
1. Copy toàn bộ Deploy Logs
2. Copy HTTP Logs (các request bị 502)
3. Kiểm tra Variables (ẩn các giá trị nhạy cảm)
4. Tạo issue hoặc hỏi trong Railway Discord

---

## Tài liệu tham khảo

- [Railway Documentation](https://docs.railway.app/)
- [Laravel Deployment](https://laravel.com/docs/deployment)
- File `RAILWAY_ENV_VARS.md` trong project này
