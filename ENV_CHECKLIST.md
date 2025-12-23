# Checklist Biến Môi Trường Railway

## 📋 Kiểm tra biến môi trường hiện tại

Dựa trên hình ảnh Railway Variables của bạn, đây là phân tích:

---

## ✅ Các biến ĐÃ CÓ:

1. ✅ `APP_KEY` - Đã có (base64:grH/CDJh7QzHrk+ef1CUotuywbiZLTKH8NCAYJ2Vvf8=)
2. ✅ `DB_DATABASE` - Đã có (vietlance)
3. ✅ `DB_HOST` - Đã có (trolley.proxy.rlwy.net)
4. ✅ `DB_PASSWORD` - Đã có (masked)
5. ✅ `DB_PORT` - Đã có (21099)
6. ✅ `DB_USER` - Đã có (root) ⚠️ **NHƯNG Laravel cần `DB_USERNAME`**
7. ✅ `MYSQL_URL` - Đã có (connection string)
8. ✅ `SESSION_SECRET` - Đã có (masked)

---

## ❌ Các biến CÒN THIẾU (QUAN TRỌNG):

### 1. Application Configuration

```bash
APP_NAME=Vietlance
APP_ENV=production  # ⚠️ Hiện tại bạn có "vietlance", nên đổi thành "production"
APP_DEBUG=false
APP_URL=https://vietlance-production.up.railway.app
```

### 2. Database Configuration

```bash
DB_CONNECTION=mysql
DB_USERNAME=root  # ⚠️ Bạn có DB_USER nhưng Laravel cần DB_USERNAME
```

### 3. Session Configuration

```bash
SESSION_DRIVER=file
```

### 4. Server Configuration (QUAN TRỌNG!)

```bash
HOST=0.0.0.0  # ⚠️ RẤT QUAN TRỌNG để Railway có thể kết nối!
```

---

## 🔧 Các biến cần SỬA:

### 1. `APP_ENV`
- **Hiện tại:** `APP_ENV=vietlance`
- **Nên là:** `APP_ENV=production`
- **Lý do:** Laravel cần biết môi trường là production để tối ưu hóa

### 2. `DB_USER` → `DB_USERNAME`
- **Hiện tại:** `DB_USER=root`
- **Nên thêm:** `DB_USERNAME=root`
- **Lý do:** Laravel sử dụng `DB_USERNAME` trong config, không phải `DB_USER`

---

## 📝 Danh sách đầy đủ cần thêm vào Railway Variables:

Vào Railway Dashboard → Service "vietlance" → Tab "Variables" → Click "New Variable" và thêm:

```bash
# Application
APP_NAME=Vietlance
APP_ENV=production
APP_DEBUG=false
APP_URL=https://vietlance-production.up.railway.app

# Database (thêm)
DB_CONNECTION=mysql
DB_USERNAME=root

# Session
SESSION_DRIVER=file

# Server (QUAN TRỌNG!)
HOST=0.0.0.0
```

---

## 🎯 Thứ tự ưu tiên:

### 🔴 QUAN TRỌNG NHẤT (Thêm ngay):
1. **`HOST=0.0.0.0`** - Cần thiết để Railway có thể kết nối đến ứng dụng
2. **`DB_USERNAME=root`** - Laravel cần biến này để kết nối database
3. **`DB_CONNECTION=mysql`** - Laravel cần biết loại database

### 🟡 QUAN TRỌNG (Nên thêm):
4. **`APP_NAME=Vietlance`** - Tên ứng dụng
5. **`APP_ENV=production`** - Sửa từ "vietlance" thành "production"
6. **`APP_DEBUG=false`** - Tắt debug mode trong production
7. **`APP_URL=https://vietlance-production.up.railway.app`** - URL của ứng dụng

### 🟢 TÙY CHỌN (Có thể thêm sau):
8. **`SESSION_DRIVER=file`** - Driver cho session (mặc định là file)

---

## 📋 Checklist hoàn chỉnh:

Sau khi thêm, bạn nên có **tối thiểu** các biến sau:

### Application (6 biến):
- [x] `APP_KEY` ✅
- [ ] `APP_NAME` ❌
- [ ] `APP_ENV` ⚠️ (có nhưng sai giá trị)
- [ ] `APP_DEBUG` ❌
- [ ] `APP_URL` ❌
- [ ] `HOST` ❌ **QUAN TRỌNG!**

### Database (6 biến):
- [x] `DB_HOST` ✅
- [x] `DB_PORT` ✅
- [x] `DB_DATABASE` ✅
- [x] `DB_PASSWORD` ✅
- [ ] `DB_CONNECTION` ❌
- [ ] `DB_USERNAME` ❌ (có `DB_USER` nhưng cần `DB_USERNAME`)

### Session (2 biến):
- [x] `SESSION_SECRET` ✅
- [ ] `SESSION_DRIVER` ❌

### Other:
- [x] `MYSQL_URL` ✅ (bonus, không bắt buộc)

---

## 🚀 Hướng dẫn thêm biến:

### Cách 1: Thêm từng biến (Khuyến nghị)

1. Vào Railway Dashboard → Service "vietlance" → Tab "Variables"
2. Click **"New Variable"**
3. Thêm từng biến theo danh sách trên
4. Click **"Add"** sau mỗi biến

### Cách 2: Sử dụng Raw Editor

1. Vào Railway Dashboard → Service "vietlance" → Tab "Variables"
2. Click **"Raw Editor"**
3. Copy và paste các biến còn thiếu:

```bash
APP_NAME=Vietlance
APP_ENV=production
APP_DEBUG=false
APP_URL=https://vietlance-production.up.railway.app
DB_CONNECTION=mysql
DB_USERNAME=root
SESSION_DRIVER=file
HOST=0.0.0.0
```

4. Click **"Save"**

---

## ⚠️ Lưu ý quan trọng:

1. **`HOST=0.0.0.0`** là **BẮT BUỘC** để Railway có thể kết nối từ bên ngoài. Nếu thiếu biến này, bạn sẽ gặp lỗi 502 Bad Gateway.

2. **`DB_USERNAME`** khác với `DB_USER`. Laravel config sử dụng `DB_USERNAME`, nên cần thêm biến này.

3. **`APP_ENV=production`** nên được set đúng để Laravel hoạt động tối ưu trong production.

4. Sau khi thêm biến, **Redeploy** service để áp dụng thay đổi:
   - Vào tab "Deployments"
   - Click "Redeploy"

---

## 🔍 Kiểm tra sau khi thêm:

1. **Redeploy service:**
   - Railway Dashboard → Deployments → Redeploy

2. **Kiểm tra Deploy Logs:**
   - Tìm dòng: `Starting PHP built-in server on 0.0.0.0:8080`
   - Đảm bảo không có ERROR

3. **Kiểm tra HTTP Logs:**
   - Request đến `/` phải trả về 200 (không phải 502)

---

## 📚 Tài liệu tham khảo:

- File `FIX_502_ERROR.md` - Hướng dẫn fix lỗi 502
- File `RAILWAY_ENV_VARS.md` - Hướng dẫn chi tiết về biến môi trường
- [Laravel Configuration](https://laravel.com/docs/configuration)

---

## ✅ Tóm tắt:

**Hiện tại bạn có:** 9 biến (8 service variables + 8 Railway auto variables)

**Cần thêm:** 8 biến quan trọng:
1. `HOST=0.0.0.0` ⚠️ **QUAN TRỌNG NHẤT**
2. `DB_USERNAME=root`
3. `DB_CONNECTION=mysql`
4. `APP_NAME=Vietlance`
5. `APP_ENV=production` (sửa từ "vietlance")
6. `APP_DEBUG=false`
7. `APP_URL=https://vietlance-production.up.railway.app`
8. `SESSION_DRIVER=file`

**Tổng cộng sau khi thêm:** ~17 biến (đủ cho Laravel production)
