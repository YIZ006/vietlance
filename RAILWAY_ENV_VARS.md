# Railway Environment Variables Guide

Hướng dẫn cấu hình các biến môi trường (Environment Variables) cho ứng dụng Vietlance trên Railway.

## Cách thêm biến môi trường trên Railway

1. Vào **Railway Dashboard** → Chọn project **vietlance**
2. Click vào service **vietlance**
3. Vào tab **Variables**
4. Click **New Variable** để thêm từng biến
5. Hoặc click **Raw Editor** để paste tất cả cùng lúc

---

## Biến môi trường bắt buộc (Required)

### 1. Application Configuration

```bash
APP_NAME=Vietlance
APP_ENV=production
APP_KEY=base64:YOUR_APP_KEY_HERE
APP_DEBUG=false
APP_URL=https://your-app-name.up.railway.app
```

**Lưu ý:**
- `APP_KEY`: Chạy `php artisan key:generate` trên local để lấy key, hoặc Railway sẽ tự generate
- `APP_URL`: Thay `your-app-name` bằng domain Railway của bạn

### 2. Database Configuration

```bash
DB_CONNECTION=mysql
DB_HOST=trolley.proxy.rlwy.net
DB_PORT=21099
DB_DATABASE=vietlance
DB_USERNAME=root
DB_PASSWORD=luMWkXCoRdcLsMyzHUTLkMSleRZBUoih
```

**Hoặc nếu bạn dùng Railway MySQL service:**

```bash
DB_CONNECTION=mysql
DB_HOST=${{MySQL.MYSQLHOST}}
DB_PORT=${{MySQL.MYSQLPORT}}
DB_DATABASE=${{MySQL.MYSQLDATABASE}}
DB_USERNAME=${{MySQL.MYSQLUSER}}
DB_PASSWORD=${{MySQL.MYSQLPASSWORD}}
```

### 3. Session Configuration

```bash
SESSION_DRIVER=file
SESSION_SECRET=8i9mibnwWRqnV33ybk1+O1gNcwIJApw13etvT4L+myE=
```

**Lưu ý:** `SESSION_SECRET` là một chuỗi base64 ngẫu nhiên, bạn có thể generate mới bằng:
```bash
php artisan key:generate --show
```

---

## Biến môi trường tùy chọn (Optional)

### 4. Cache Configuration

```bash
CACHE_DRIVER=file
QUEUE_CONNECTION=sync
```

### 5. Mail Configuration

```bash
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@vietlance.com
MAIL_FROM_NAME="${APP_NAME}"
```

**Lưu ý:** Nếu dùng Gmail, cần tạo **App Password** trong Google Account settings.

### 6. OAuth Configuration (Google)

```bash
GOOGLE_CLIENT_ID=your-google-client-id
GOOGLE_CLIENT_SECRET=your-google-client-secret
GOOGLE_REDIRECT_URI=https://your-app-name.up.railway.app/auth/google/callback
```

**Cách lấy Google OAuth credentials:**
1. Vào [Google Cloud Console](https://console.cloud.google.com/)
2. Tạo project mới hoặc chọn project hiện có
3. Enable **Google+ API**
4. Tạo **OAuth 2.0 Client ID**
5. Thêm authorized redirect URI: `https://your-app-name.up.railway.app/auth/google/callback`

### 7. OAuth Configuration (GitHub)

```bash
GITHUB_CLIENT_ID=your-github-client-id
GITHUB_CLIENT_SECRET=your-github-client-secret
GITHUB_REDIRECT_URI=https://your-app-name.up.railway.app/auth/github/callback
```

**Cách lấy GitHub OAuth credentials:**
1. Vào GitHub → Settings → Developer settings → OAuth Apps
2. Click **New OAuth App**
3. Điền thông tin:
   - **Application name**: Vietlance
   - **Homepage URL**: `https://your-app-name.up.railway.app`
   - **Authorization callback URL**: `https://your-app-name.up.railway.app/auth/github/callback`
4. Copy **Client ID** và **Client Secret**

---

## Biến môi trường tự động từ Railway

Railway tự động cung cấp các biến sau (không cần set thủ công):

- `PORT`: Port mà ứng dụng cần listen (Railway tự động set)
- `RAILWAY_ENVIRONMENT`: Môi trường hiện tại (production, preview, etc.)
- `RAILWAY_PROJECT_ID`: ID của project
- `RAILWAY_SERVICE_ID`: ID của service

---

## Template đầy đủ để copy vào Railway

Copy toàn bộ nội dung sau vào **Raw Editor** của Railway Variables:

```bash
# Application
APP_NAME=Vietlance
APP_ENV=production
APP_KEY=base64:YOUR_APP_KEY_HERE
APP_DEBUG=false
APP_URL=https://your-app-name.up.railway.app

# Database
DB_CONNECTION=mysql
DB_HOST=trolley.proxy.rlwy.net
DB_PORT=21099
DB_DATABASE=vietlance
DB_USERNAME=root
DB_PASSWORD=luMWkXCoRdcLsMyzHUTLkMSleRZBUoih

# Session
SESSION_DRIVER=file
SESSION_SECRET=8i9mibnwWRqnV33ybk1+O1gNcwIJApw13etvT4L+myE=

# Cache
CACHE_DRIVER=file
QUEUE_CONNECTION=sync

# Mail (Optional - Update với thông tin của bạn)
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@vietlance.com
MAIL_FROM_NAME="Vietlance"

# Google OAuth (Optional)
GOOGLE_CLIENT_ID=your-google-client-id
GOOGLE_CLIENT_SECRET=your-google-client-secret
GOOGLE_REDIRECT_URI=https://your-app-name.up.railway.app/auth/google/callback

# GitHub OAuth (Optional)
GITHUB_CLIENT_ID=your-github-client-id
GITHUB_CLIENT_SECRET=your-github-client-secret
GITHUB_REDIRECT_URI=https://your-app-name.up.railway.app/auth/github/callback
```

---

## Sau khi thêm biến môi trường

1. **Redeploy** service để áp dụng thay đổi:
   - Vào **Deployments** tab
   - Click **Redeploy** hoặc push code mới lên GitHub

2. **Chạy migrations** (nếu chưa chạy):
   ```bash
   # Vào Railway dashboard → Service → Deploy Logs
   # Hoặc dùng Railway CLI:
   railway run php artisan migrate --force
   ```

3. **Kiểm tra logs** để đảm bảo không có lỗi:
   - Vào **Logs** tab trong Railway dashboard

---

## Troubleshooting

### Lỗi "Invalid address: 0.0.0.0:$PORT"
- **Nguyên nhân**: Railway tự động set biến `PORT`, nhưng ứng dụng chưa được cấu hình để sử dụng
- **Giải pháp**: Đã được fix trong Dockerfile và entrypoint script

### Lỗi database connection
- Kiểm tra các biến `DB_*` đã được set đúng chưa
- Đảm bảo MySQL service đã online trên Railway
- Kiểm tra firewall/network settings

### Lỗi APP_KEY
- Railway có thể tự generate, nhưng tốt nhất là set thủ công
- Chạy `php artisan key:generate` trên local và copy key vào Railway

---

## Lưu ý quan trọng

1. **Không commit `.env` file** vào Git (đã có trong `.gitignore`)
2. **Bảo mật**: Không chia sẻ các giá trị biến môi trường công khai
3. **Railway Variables**: Các biến được encrypt và chỉ visible bởi người có quyền truy cập project
4. **Redeploy**: Mỗi khi thay đổi biến môi trường, cần redeploy để áp dụng

