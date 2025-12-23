# Docker Setup Guide - Vietlance

Hướng dẫn sử dụng Docker để chạy ứng dụng Vietlance.

## Yêu cầu

- Docker Engine 20.10+
- Docker Compose 2.0+

## Cấu trúc Docker

- **Dockerfile**: Multi-stage build cho Laravel application
- **docker-compose.yml**: Orchestration với MySQL và Redis
- **docker/**: Thư mục chứa các file cấu hình
  - `nginx.conf`: Cấu hình Nginx chính
  - `default.conf`: Cấu hình site Laravel
  - `supervisord.conf`: Cấu hình Supervisor để chạy PHP-FPM và Nginx
  - `docker-entrypoint.sh`: Script khởi tạo container

## Cách sử dụng

### 1. Tạo file .env

Copy `.env.example` thành `.env` và cấu hình các biến môi trường:

```bash
cp .env.example .env
```

Cập nhật các biến quan trọng:
- `APP_KEY`: Generate bằng `php artisan key:generate`
- `DB_*`: Thông tin kết nối database
- `SESSION_SECRET`: Secret key cho session

### 2. Build và chạy containers

```bash
# Build và start tất cả services
docker-compose up -d --build

# Xem logs
docker-compose logs -f app

# Stop containers
docker-compose down

# Stop và xóa volumes (xóa dữ liệu database)
docker-compose down -v
```

### 3. Chạy migrations và seeders

```bash
# Vào container app
docker-compose exec app sh

# Chạy migrations
php artisan migrate

# Chạy seeders (nếu cần)
php artisan db:seed

# Hoặc chạy từ bên ngoài
docker-compose exec app php artisan migrate
docker-compose exec app php artisan db:seed
```

### 4. Truy cập ứng dụng

- **Application**: http://localhost:8000
- **MySQL**: localhost:3306
- **Redis**: localhost:6379

## Các lệnh hữu ích

```bash
# Xem logs của tất cả services
docker-compose logs -f

# Xem logs của service cụ thể
docker-compose logs -f app
docker-compose logs -f mysql

# Restart service
docker-compose restart app

# Rebuild container sau khi thay đổi code
docker-compose up -d --build app

# Xem status containers
docker-compose ps

# Vào shell của container
docker-compose exec app sh
docker-compose exec mysql bash

# Chạy artisan commands
docker-compose exec app php artisan [command]

# Clear cache
docker-compose exec app php artisan cache:clear
docker-compose exec app php artisan config:clear
docker-compose exec app php artisan view:clear
```

## Production Deployment

### Build Docker Image

```bash
# Build image
docker build -t vietlance:latest .

# Tag image
docker tag vietlance:latest your-registry/vietlance:latest

# Push to registry
docker push your-registry/vietlance:latest
```

### Environment Variables cho Production

Đảm bảo các biến sau được set trong production:

- `APP_ENV=production`
- `APP_DEBUG`: Mặc định là `false` trong production - không cần set thủ công
- `APP_KEY`: Phải được set
- `DB_*`: Thông tin database production
- `SESSION_SECRET`: Secret key
- `HOST` và `PORT`: Railway tự động quản lý - không cần set thủ công
- `MAIL_*`: Cấu hình email
- `GOOGLE_CLIENT_ID`, `GOOGLE_CLIENT_SECRET`: OAuth Google
- `GITHUB_CLIENT_ID`, `GITHUB_CLIENT_SECRET`: OAuth GitHub

### Railway Deployment

1. Kết nối GitHub repository với Railway
2. Set các environment variables trong Railway dashboard
3. Railway sẽ tự động build và deploy từ Dockerfile

**Lưu ý quan trọng về Railway:**
- **HOST và PORT**: Railway tự động quản lý - không cần set thủ công. Script `start-server.sh` sẽ tự động đọc `PORT` từ Railway và bind trên `0.0.0.0`
- **APP_DEBUG**: Mặc định là `false` trong production - không cần set thủ công
- Script `start-server.sh` được sử dụng làm start command (đã được cấu hình trong `railway.json`)

## Troubleshooting

### Container không start

```bash
# Kiểm tra logs
docker-compose logs app

# Kiểm tra MySQL connection
docker-compose exec app php artisan tinker
>>> DB::connection()->getPdo();
```

### Permission errors

```bash
# Fix permissions
docker-compose exec app chown -R www-data:www-data storage bootstrap/cache
docker-compose exec app chmod -R 775 storage bootstrap/cache
```

### Database connection failed

- Kiểm tra MySQL container đã start: `docker-compose ps`
- Kiểm tra environment variables trong `.env`
- Đợi MySQL sẵn sàng (entrypoint script sẽ tự động wait)

### Assets không load

```bash
# Rebuild assets
docker-compose exec app npm install
docker-compose exec app npm run build
```

## Notes

- Storage và cache volumes được mount để persist data
- MySQL data được lưu trong volume `mysql_data`
- Entrypoint script tự động chạy migrations (có thể comment trong script nếu muốn chạy manual)
- Health checks được cấu hình cho tất cả services

