# Hướng dẫn thêm dữ liệu mẫu vào Database

## Cách 1: Chạy Seeder qua Artisan (Khuyến nghị)

### Bước 1: Mở terminal trong thư mục project
```bash
cd "E:\tài liệu\Môn Project2_php_lavarel\vietlance"
```

### Bước 2: Chạy seeder
```bash
php artisan db:seed
```

Hoặc chạy từng seeder riêng:
```bash
php artisan db:seed --class=AdminSeeder
php artisan db:seed --class=FreelanceSeeder
php artisan db:seed --class=ClientSeeder
```

## Cách 2: Chạy SQL trực tiếp trong phpMyAdmin

1. Mở phpMyAdmin: `http://localhost/phpmyadmin`
2. Chọn database `vietlance`
3. Click tab **SQL**
4. Copy và chạy file `database/seed_all.sql`

## Dữ liệu mẫu sẽ được thêm:

### 📌 Admin (3 tài khoản):
1. **Super Admin**
   - Email: `superadmin@vietlance.com`
   - Admin Login: `superadmin`
   - Password: `password`
   - Role: `superadmin`
   - Status: `active`

2. **Admin**
   - Email: `admin@vietlance.com`
   - Admin Login: `admin`
   - Password: `password`
   - Role: `admin`
   - Status: `active`

3. **Viewer**
   - Email: `viewer@vietlance.com`
   - Admin Login: `viewer`
   - Password: `password`
   - Role: `viewer`
   - Status: `active`

### 📌 Freelance (2 tài khoản):
1. **Nguyễn Văn A**
   - Email: `freelance1@vietlance.com`
   - Password: `password`
   - Skills: PHP, Laravel, JavaScript, Vue.js, MySQL
   - Hourly Rate: $25
   - Experience: 5 years

2. **Trần Thị B**
   - Email: `freelance2@vietlance.com`
   - Password: `password`
   - Skills: Figma, Adobe XD, Photoshop, Illustrator
   - Hourly Rate: $20
   - Experience: 3 years

### 📌 Client (2 tài khoản):
1. **Công ty ABC**
   - Email: `client1@vietlance.com`
   - Password: `password`
   - Company: Công ty TNHH ABC

2. **Công ty XYZ**
   - Email: `client2@vietlance.com`
   - Password: `password`
   - Company: Công ty Cổ phần XYZ

## Lưu ý:

⚠️ **QUAN TRỌNG**: 
- Tất cả password mặc định là: `password`
- Password đã được hash bằng bcrypt
- Nên đổi password sau khi đăng nhập lần đầu
- Seeder sẽ không tạo duplicate nếu email đã tồn tại (do unique constraint)

## Kiểm tra sau khi chạy:

```bash
# Kiểm tra số lượng admin
php artisan tinker
>>> App\Models\Admin::count()

# Kiểm tra số lượng freelance
>>> App\Models\Freelance::count()

# Kiểm tra số lượng client
>>> App\Models\Client::count()
```

