# Hướng dẫn tạo bảng profiles

## Cách 1: Sử dụng Migration (Khuyến nghị)

### Bước 1: Mở Terminal/PowerShell
Mở terminal tại thư mục dự án:
```
E:\tài liệu\Môn Project2_php_lavarel\vietlance
```

### Bước 2: Chạy Migration
```bash
php artisan migrate
```

Hoặc nếu chỉ muốn chạy migration cụ thể:
```bash
php artisan migrate --path=database/migrations/2025_12_11_101410_create_profiles_table.php
```

## Cách 2: Chạy SQL trực tiếp trong phpMyAdmin (Nhanh nhất)

### Bước 1: Mở phpMyAdmin
1. Truy cập `http://localhost/phpmyadmin`
2. Chọn database `vietlance`

### Bước 2: Chạy SQL Script
1. Click vào tab **SQL**
2. Copy toàn bộ nội dung từ file `database/create_profiles_table.sql`
3. Paste vào ô SQL
4. Click **Go** để thực thi

Hoặc copy script sau:

```sql
USE `vietlance`;

CREATE TABLE IF NOT EXISTS `profiles` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `talent_id` BIGINT UNSIGNED NOT NULL,
    
    -- Profile Overview
    `profile_overview` TEXT NULL,
    
    -- Basic Information
    `experience_level` ENUM('entry', 'intermediate', 'expert') NULL,
    `hours_per_week` VARCHAR(255) NULL,
    `open_to_contract_to_hire` TINYINT(1) NOT NULL DEFAULT 0,
    `visibility` ENUM('public', 'private') NOT NULL DEFAULT 'public',
    `project_preference` VARCHAR(255) NULL,
    `earnings_privacy` TINYINT(1) NOT NULL DEFAULT 0,
    
    -- Video Introduction
    `video_introduction_url` VARCHAR(500) NULL,
    
    -- Languages (stored as JSON)
    `languages` JSON NULL,
    
    -- Verifications
    `id_verified` TINYINT(1) NOT NULL DEFAULT 0,
    `military_veteran` TINYINT(1) NOT NULL DEFAULT 0,
    
    -- Work History
    `work_history` JSON NULL,
    
    -- Skills
    `skills` JSON NULL,
    
    -- Categories
    `primary_category` VARCHAR(255) NULL,
    `sub_categories` JSON NULL,
    
    -- Specialized Profiles
    `specialized_profiles` JSON NULL,
    `published_profiles_count` INT NOT NULL DEFAULT 0,
    
    -- Linked Accounts
    `github_username` VARCHAR(255) NULL,
    `stackoverflow_username` VARCHAR(255) NULL,
    `linkedin_url` VARCHAR(500) NULL,
    `portfolio_url` VARCHAR(500) NULL,
    
    -- Certifications
    `certifications` JSON NULL,
    
    -- Employment History
    `employment_history` JSON NULL,
    
    -- Other Experiences
    `other_experiences` JSON NULL,
    
    -- Education
    `education` JSON NULL,
    
    -- Licenses
    `licenses` JSON NULL,
    
    -- Project Catalog
    `project_catalog` JSON NULL,
    
    -- Testimonials
    `testimonials` JSON NULL,
    
    -- AI Preference
    `ai_data_training_opt_in` TINYINT(1) NOT NULL DEFAULT 0,
    
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    `updated_at` TIMESTAMP NULL DEFAULT NULL,
    
    PRIMARY KEY (`id`),
    UNIQUE KEY `profiles_talent_id_unique` (`talent_id`),
    CONSTRAINT `profiles_talent_id_foreign` FOREIGN KEY (`talent_id`) REFERENCES `talent` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

## Kiểm tra sau khi tạo bảng

### Kiểm tra trong phpMyAdmin:
1. Mở database `vietlance`
2. Kiểm tra bảng `profiles` đã được tạo
3. Kiểm tra các cột và foreign key đã đúng

### Kiểm tra bằng Laravel:
```bash
php artisan tinker
```

Trong tinker:
```php
// Kiểm tra bảng đã tồn tại
Schema::hasTable('profiles');

// Kiểm tra model hoạt động
\App\Models\Profile::count();

// Tạo profile mẫu cho talent đầu tiên
$talent = \App\Models\Talent::first();
if ($talent) {
    $talent->profile()->create([
        'profile_overview' => 'Sample profile overview',
        'experience_level' => 'intermediate',
        'hours_per_week' => 'More than 30 hrs/week',
        'visibility' => 'public',
    ]);
    echo "Profile created successfully!";
}
```

## Lưu ý quan trọng

1. **Bảng `talent` phải tồn tại trước**: Đảm bảo bảng `talent` đã được tạo trước khi tạo bảng `profiles`
2. **Foreign Key**: Bảng `profiles` có foreign key liên kết với bảng `talent`, nên khi xóa talent thì profile cũng sẽ bị xóa (CASCADE)
3. **Unique Constraint**: Mỗi talent chỉ có thể có 1 profile (talent_id là unique)

## Cấu trúc bảng

Bảng `profiles` bao gồm các trường chính:

- **Thông tin cơ bản**: profile_overview, experience_level, hours_per_week, visibility
- **Media**: video_introduction_url, portfolio_url
- **Liên kết**: github_username, stackoverflow_username, linkedin_url
- **Dữ liệu JSON**: languages, skills, certifications, employment_history, education, etc.
- **Xác minh**: id_verified, military_veteran
- **Cài đặt**: visibility, earnings_privacy, ai_data_training_opt_in

## Troubleshooting

### Lỗi: Table 'talent' doesn't exist
- **Nguyên nhân**: Bảng `talent` chưa được tạo
- **Giải pháp**: Chạy migration tạo bảng `talent` trước:
  ```bash
  php artisan migrate
  ```

### Lỗi: Foreign key constraint fails
- **Nguyên nhân**: talent_id không tồn tại trong bảng `talent`
- **Giải pháp**: Đảm bảo talent_id hợp lệ khi tạo profile

### Lỗi: Duplicate entry for key 'profiles_talent_id_unique'
- **Nguyên nhân**: Talent đã có profile
- **Giải pháp**: Mỗi talent chỉ có thể có 1 profile, sử dụng `updateOrCreate` thay vì `create`

