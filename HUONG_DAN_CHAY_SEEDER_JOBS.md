# Hướng dẫn chạy Seeder cho Job Categories và IT Jobs

## Cách 1: Chạy bằng Artisan Command (Khuyến nghị)

```bash
cd "E:\tài liệu\Môn Project2_php_lavarel\vietlance"
php artisan migrate
php artisan db:seed --class=JobCategorySeeder
php artisan db:seed --class=ItJobSeeder
```

Hoặc chạy tất cả seeders:
```bash
php artisan db:seed
```

## Cách 2: Chạy SQL trực tiếp trong phpMyAdmin

1. Mở phpMyAdmin
2. Chọn database `vietlance`
3. Chạy file `database/create_job_tables.sql` để tạo bảng
4. Chạy file `database/seed_jobs_complete.sql` để thêm dữ liệu

## Kiểm tra dữ liệu đã được thêm

Sau khi chạy seeder, bạn sẽ có:
- **13 danh mục công việc** trong bảng `job_categories`
- **~120+ công việc IT** trong bảng `it_jobs`

## Giải thích về "Số lượng Công việc"

Số lượng công việc được tính tự động từ:
- Bảng `it_jobs` có cột `category_id` liên kết với `job_categories.category_id`
- Laravel sử dụng `withCount('jobs')` để đếm số lượng công việc thuộc mỗi danh mục
- Kết quả được hiển thị trong cột "Số lượng Công việc" ở trang quản lý danh mục

Ví dụ:
- Danh mục "Lập trình & Phát triển phần mềm" sẽ có ~16 công việc
- Danh mục "Khoa học dữ liệu & Trí tuệ nhân tạo" sẽ có ~10 công việc
- ...

