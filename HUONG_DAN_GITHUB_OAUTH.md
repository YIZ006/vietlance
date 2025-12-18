# Hướng dẫn cấu hình GitHub OAuth cho Freelance

## Bước 1: Tạo GitHub OAuth App

1. Đăng nhập vào GitHub và vào **Settings** > **Developer settings** > **OAuth Apps**
2. Click **New OAuth App**
3. Điền thông tin:
   - **Application name**: `Vietlance Freelance`
   - **Homepage URL**: `http://localhost:8000`
   - **Authorization callback URL**: `http://localhost:8000/freelance/auth/github/callback`
4. Click **Register application**
5. Copy **Client ID** và **Client Secret**

## Bước 2: Cấu hình trong file .env

Thêm các dòng sau vào file `.env`:

```env
GITHUB_CLIENT_ID=your_github_client_id
GITHUB_CLIENT_SECRET=your_github_client_secret
GITHUB_REDIRECT_URI=http://localhost:8000/freelance/auth/github/callback
```

## Bước 3: Cài đặt Laravel Socialite

Chạy lệnh:

```bash
composer require laravel/socialite
```

## Bước 4: Chạy migration

```bash
php artisan migrate
```

Migration này sẽ thêm các trường `github_id`, `github_token`, `github_refresh_token` vào bảng `freelance`.

## Bước 5: Xóa cache config

```bash
php artisan config:clear
php artisan cache:clear
```

## Bước 6: Kiểm tra

1. Truy cập: `http://localhost:8000/freelance/login`
2. Click nút **"Đăng nhập bằng GitHub"**
3. Authorize ứng dụng trên GitHub
4. Bạn sẽ được redirect về dashboard

## Lưu ý cho Production

Khi deploy lên production, cần:

1. Cập nhật **Authorization callback URL** trong GitHub OAuth App:
   ```
   https://yourdomain.com/freelance/auth/github/callback
   ```

2. Cập nhật file `.env`:
   ```env
   GITHUB_REDIRECT_URI=https://yourdomain.com/freelance/auth/github/callback
   ```

3. Đảm bảo HTTPS được bật (GitHub yêu cầu HTTPS cho production)

## Xử lý lỗi thường gặp

### Lỗi: "Invalid credentials"
- Kiểm tra lại `GITHUB_CLIENT_ID` và `GITHUB_CLIENT_SECRET` trong file `.env`
- Đảm bảo callback URL khớp với cấu hình trong GitHub

### Lỗi: "Redirect URI mismatch"
- Kiểm tra callback URL trong GitHub OAuth App phải khớp với `GITHUB_REDIRECT_URI` trong `.env`

### Lỗi: "Class 'Laravel\Socialite\Facades\Socialite' not found"
- Chạy lại: `composer require laravel/socialite`
- Chạy: `composer dump-autoload`

