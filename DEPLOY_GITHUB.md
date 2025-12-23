# Hướng dẫn Deploy lên GitHub và Railway

## Repository GitHub
**URL:** https://github.com/YIZ006/vietlance

---

## Các bước Deploy lên GitHub

### 1. Kiểm tra Git Repository

Mở terminal trong thư mục `vietlance` và chạy:

```bash
# Kiểm tra git status
git status

# Kiểm tra remote repository
git remote -v
```

### 2. Nếu chưa có Git Repository

```bash
# Khởi tạo git repository
git init

# Thêm remote repository
git remote add origin https://github.com/YIZ006/vietlance.git

# Hoặc nếu đã có remote nhưng sai URL:
git remote set-url origin https://github.com/YIZ006/vietlance.git
```

### 3. Thêm và Commit các thay đổi

```bash
# Xem các file đã thay đổi
git status

# Thêm tất cả các file (trừ những file trong .gitignore)
git add .

# Commit với message
git commit -m "Update: Fix 502 error, improve start-server.sh, add deployment docs"

# Hoặc commit từng file cụ thể:
git add start-server.sh
git add FIX_502_ERROR.md
git add DEPLOY_GITHUB.md
git commit -m "Add deployment documentation and fix server startup script"
```

### 4. Push lên GitHub

```bash
# Push lên branch main
git push -u origin main

# Hoặc nếu branch là master:
git push -u origin master

# Nếu gặp lỗi "rejected", có thể cần force push (cẩn thận!):
# git push -u origin main --force
```

### 5. Kiểm tra trên GitHub

Vào https://github.com/YIZ006/vietlance và kiểm tra:
- ✅ Các file mới đã được push
- ✅ `start-server.sh` đã được cập nhật
- ✅ `FIX_502_ERROR.md` đã có trong repository

---

## Kết nối với Railway

### 1. Railway tự động deploy từ GitHub

Nếu Railway đã được kết nối với GitHub repository:
- Mỗi khi bạn push code lên GitHub
- Railway sẽ tự động detect và deploy
- Vào Railway Dashboard → Deployments để xem quá trình deploy

### 2. Kiểm tra Railway Settings

1. Vào Railway Dashboard → Project "mellow-compassion"
2. Vào Service "vietlance" → Tab "Settings"
3. Kiểm tra **"Source"** section:
   - ✅ Repository: `YIZ006/vietlance`
   - ✅ Branch: `main` hoặc `master`
   - ✅ Auto Deploy: Enabled

### 3. Manual Deploy (nếu cần)

Nếu auto-deploy không hoạt động:
1. Vào Railway Dashboard → Service "vietlance"
2. Vào tab "Deployments"
3. Click "Redeploy" hoặc "Deploy Latest"

---

## Checklist trước khi Push

Trước khi push code lên GitHub, đảm bảo:

- [ ] **Không commit file `.env`** (đã có trong `.gitignore`)
- [ ] **Không commit file nhạy cảm** (passwords, API keys)
- [ ] **Đã test code trên local** (nếu có thể)
- [ ] **Commit message rõ ràng** (mô tả thay đổi)
- [ ] **Các file quan trọng đã được thêm:**
  - [ ] `start-server.sh` (đã cập nhật)
  - [ ] `FIX_502_ERROR.md` (file mới)
  - [ ] `DEPLOY_GITHUB.md` (file này)
  - [ ] `railway.json` (cấu hình Railway)
  - [ ] `Dockerfile` (nếu có thay đổi)

---

## Các lệnh Git thường dùng

### Xem thay đổi
```bash
# Xem status
git status

# Xem diff (thay đổi)
git diff

# Xem log
git log --oneline
```

### Thêm và Commit
```bash
# Thêm tất cả
git add .

# Thêm file cụ thể
git add start-server.sh

# Commit
git commit -m "Your commit message"

# Commit với message dài
git commit -m "Fix: Improve server startup script
- Add database connection check
- Add Laravel bootstrap test
- Improve error handling"
```

### Push và Pull
```bash
# Push lên GitHub
git push origin main

# Pull từ GitHub (nếu có thay đổi từ nơi khác)
git pull origin main

# Xem remote
git remote -v
```

### Branch Management
```bash
# Tạo branch mới
git checkout -b feature/new-feature

# Chuyển branch
git checkout main

# Merge branch
git merge feature/new-feature

# Xóa branch
git branch -d feature/new-feature
```

---

## Troubleshooting

### Lỗi: "fatal: not a git repository"
```bash
# Giải pháp: Khởi tạo git repository
git init
```

### Lỗi: "remote origin already exists"
```bash
# Giải pháp: Xóa và thêm lại remote
git remote remove origin
git remote add origin https://github.com/YIZ006/vietlance.git
```

### Lỗi: "Updates were rejected"
```bash
# Giải pháp 1: Pull trước khi push
git pull origin main --rebase
git push origin main

# Giải pháp 2: Force push (CẨN THẬN! Chỉ dùng nếu chắc chắn)
git push origin main --force
```

### Lỗi: "Permission denied"
```bash
# Giải pháp: Kiểm tra authentication
# - Sử dụng Personal Access Token thay vì password
# - Hoặc setup SSH key
```

---

## Sau khi Push lên GitHub

### 1. Kiểm tra Railway Auto-Deploy

1. Vào Railway Dashboard
2. Xem tab "Deployments"
3. Sẽ có deployment mới tự động bắt đầu
4. Chờ build và deploy hoàn tất

### 2. Kiểm tra Deploy Logs

1. Vào tab "Deploy Logs"
2. Đảm bảo không có ERROR
3. Tìm dòng: `Starting PHP built-in server on 0.0.0.0:8080`

### 3. Kiểm tra HTTP Logs

1. Vào tab "HTTP Logs"
2. Test request đến `/`
3. Đảm bảo trả về 200 (không phải 502)

---

## Best Practices

### 1. Commit thường xuyên
- Commit sau mỗi feature/fix hoàn thành
- Commit message rõ ràng, mô tả thay đổi

### 2. Không commit file nhạy cảm
- `.env` file
- API keys, passwords
- Private keys

### 3. Sử dụng .gitignore
- Đã có sẵn trong project
- Kiểm tra lại nếu cần thêm file/folder

### 4. Test trước khi push
- Test trên local nếu có thể
- Kiểm tra syntax errors
- Kiểm tra file paths

### 5. Review trước khi merge
- Nếu làm việc nhóm, tạo Pull Request
- Review code trước khi merge vào main

---

## Tài liệu tham khảo

- [Git Documentation](https://git-scm.com/doc)
- [GitHub Guides](https://guides.github.com/)
- [Railway Documentation](https://docs.railway.app/)
- File `FIX_502_ERROR.md` - Hướng dẫn fix lỗi 502
- File `RAILWAY_ENV_VARS.md` - Hướng dẫn cấu hình biến môi trường

---

## Liên hệ

Nếu gặp vấn đề:
1. Kiểm tra Git status: `git status`
2. Kiểm tra Railway Deploy Logs
3. Xem file `FIX_502_ERROR.md` để troubleshoot
4. Tạo issue trên GitHub hoặc hỏi trong Railway Discord
