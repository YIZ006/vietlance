# Hướng dẫn cấu hình Google OAuth

## Bước 1: Tạo Google OAuth Credentials

1. Truy cập [Google Cloud Console](https://console.cloud.google.com/)
2. Tạo project mới hoặc chọn project có sẵn
3. Vào **APIs & Services** > **Credentials**
4. Click **Create Credentials** > **OAuth client ID**
5. Chọn **Web application**
6. Điền thông tin:
   - **Name**: `Vietlance Freelance` hoặc `Vietlance Client`
   - **Authorized JavaScript origins**: 
     - `http://localhost:8000`
   - **Authorized redirect URIs**:
     - `http://localhost:8000/freelance/auth/google/callback` (cho Freelance)
     - `http://localhost:8000/client/auth/google/callback` (cho Client)
7. Click **Create**
8. Copy **Client ID** và **Client Secret**

## Bước 2: Cấu hình trong file .env

Thêm các dòng sau vào file `.env`:

```env
GOOGLE_CLIENT_ID=your_google_client_id_here
GOOGLE_CLIENT_SECRET=your_google_client_secret_here
GOOGLE_REDIRECT_URI=http://localhost:8000/freelance/auth/google/callback
```

**Lưu ý**: Nếu bạn có cả Freelance và Client, bạn có thể dùng cùng một Client ID hoặc tạo riêng cho mỗi loại.

## Bước 3: Cấu hình trong config/services.php

File đã được cấu hình sẵn. Kiểm tra lại:

```php
'google' => [
    'client_id' => env('GOOGLE_CLIENT_ID'),
    'client_secret' => env('GOOGLE_CLIENT_SECRET'),
    'redirect' => env('GOOGLE_REDIRECT_URI'),
],
```

## Bước 4: Xóa cache config

```bash
php artisan config:clear
php artisan cache:clear
```

## Bước 5: Kiểm tra

1. Truy cập: `http://localhost:8000/freelance/login` hoặc `http://localhost:8000/client/login`
2. Click nút **"Continue with Google"**
3. Authorize ứng dụng trên Google
4. Bạn sẽ được redirect về dashboard

## Lưu ý cho Production

Khi deploy lên production, cần:

1. Cập nhật **Authorized redirect URIs** trong Google Cloud Console:
   ```
   https://yourdomain.com/freelance/auth/google/callback
   https://yourdomain.com/client/auth/google/callback
   ```

2. Cập nhật file `.env`:
   ```env
   GOOGLE_REDIRECT_URI=https://yourdomain.com/freelance/auth/google/callback
   ```

3. Đảm bảo HTTPS được bật (Google yêu cầu HTTPS cho production)

## Xử lý lỗi thường gặp

### Lỗi: "Redirect URI mismatch"
- Kiểm tra redirect URI trong Google Cloud Console phải khớp chính xác với URL trong `.env`
- Đảm bảo không có khoảng trắng thừa

### Lỗi: "Invalid client"
- Kiểm tra lại `GOOGLE_CLIENT_ID` và `GOOGLE_CLIENT_SECRET` trong file `.env`
- Chạy `php artisan config:clear` sau khi cập nhật `.env`

