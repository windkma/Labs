# Bài tập 4 - PHP và Cơ sở dữ liệu

- Sinh viên: Phan Thế Phong
- MSSV: AT200345
- Môn học: Công nghệ Web an toàn

## Cấu trúc nhiệm vụ

Mỗi yêu cầu được tách thành một trang độc lập từ `nhiemvu1.php` đến
`nhiemvu16.php`. Các trang dùng chung template trong `includes/`, giao diện
trong `css/style.css`, ảnh trong `img/`, thư viện hàm trong `libs/` và dữ liệu
upload trong `uploads/`.

| File | Nội dung |
|---|---|
| `nhiemvu1.php` | Tạo template PHP |
| `nhiemvu2.php` | Register, ResultRegister, Calculate |
| `nhiemvu3.php` | GET/POST, switch-case, bảng, phép tính, ma trận, upload 10 file |
| `nhiemvu4.php` | Các loại điều khiển form và Contact1Page |
| `nhiemvu5.php` | Đăng nhập bằng Session, khu vực admin, upload, logout |
| `nhiemvu6.php` | Cookie đăng nhập, lần đăng nhập cuối, Favorite links |
| `nhiemvu7.php` | Hàm xử lý mảng một chiều và ma trận |
| `nhiemvu8.php` | Đọc và ghi danh sách sinh viên vào file |
| `nhiemvu9.php` | List/Add/Detail/Edit/Delete/Upload với file |
| `nhiemvu10.php` | Website Việt/Anh bằng Session và hằng số |
| `nhiemvu11.php` | CRUD LOP/HOSO, phân trang 10 hồ sơ |
| `nhiemvu12.php` | Danh sách lớp và sinh viên theo lớp bằng GET |
| `nhiemvu13.php` | Trang bán laptop phía người dùng |
| `nhiemvu14.php` | Quản trị Users/Categories/Products |
| `nhiemvu15.php` | Giỏ hàng bằng Session |
| `nhiemvu16.php` | Form sản phẩm tích hợp CKEditor |

## Chạy bằng XAMPP

Có thể đặt thư mục trong `htdocs`, bật Apache và truy cập `index.php`. Hoặc
chạy PHP Development Server tại thư mục dự án:

```powershell
D:\xampp\php\php.exe -S 127.0.0.1:8080 -t D:\Subjects\cnw_bai4
```

Tài khoản mẫu của nhiệm vụ 5 và 6 là `admin` / `admin`.

## Cơ sở dữ liệu

Bật MySQL trong XAMPP rồi import lần lượt bằng phpMyAdmin:

1. `sql/nhiemvu11.sql` cho nhiệm vụ 11.
2. `sql/nhiemvu12.sql` cho nhiệm vụ 12.
3. `sql/laptop_shop.sql` cho nhiệm vụ 13-16.
4. `sql/laptop_shop_bai6.sql` cho **Bài tập 6 - Nhiệm vụ 1**.

---

# Bài tập 6 - Cơ Chế An Toàn và Kỹ Thuật Nâng Cao

## Nhiệm vụ 1: Kiện toàn và bổ sung phần nâng cao, cơ chế an toàn cho website bán laptop

Dự án được xây dựng hoàn chỉnh trong thư mục `bai6/` theo mô hình chuẩn **MVC (Model - View - Controller)** kết hợp **Front Controller Router**.

### 1. Kiến trúc thư mục `bai6/`
```text
bai6/
├── app/
│   ├── Controllers/
│   │   ├── HomeController.php          # Trang chủ, sản phẩm nổi bật, banner
│   │   ├── ProductController.php       # Danh mục, chi tiết, AJAX live search
│   │   ├── CartController.php          # Giỏ hàng AJAX (thêm, cập nhật, xóa)
│   │   ├── OrderController.php         # Thanh toán, hóa đơn, lịch sử mua hàng
│   │   ├── AuthController.php          # Đăng nhập, đăng ký AJAX, profile
│   │   └── Admin/
│   │       ├── AdminDashboardController.php # Thống kê doanh thu, đơn hàng
│   │       ├── AdminProductController.php   # CRUD laptop, upload ảnh, CKEditor
│   │       ├── AdminCategoryController.php  # CRUD danh mục hãng laptop
│   │       ├── AdminOrderController.php     # Quản lý & duyệt trạng thái đơn
│   │       └── AdminUserController.php      # Quản lý người dùng, phân quyền RBAC
│   ├── Models/
│   │   ├── Database.php        # Kết nối PDO Singleton, tự động nạp CSDL
│   │   ├── Product.php         # Truy vấn laptop, lọc giá, phân trang, trừ kho
│   │   ├── Category.php        # Hãng sản xuất kèm số lượng máy
│   │   ├── Order.php           # Transaction đặt hàng, chi tiết, thống kê
│   │   └── User.php            # Tài khoản, mã hóa mật khẩu Bcrypt
│   ├── Views/
│   │   ├── layouts/
│   │   │   ├── main.php        # Layout khách hàng (Bootstrap 5, Toast, Search)
│   │   │   └── admin.php       # Layout quản trị (Sidebar, CKEditor, Flatpickr)
│   │   ├── home/               # View trang chủ
│   │   ├── product/            # View danh sách, chi tiết laptop
│   │   ├── cart/               # View giỏ hàng tương tác AJAX
│   │   ├── order/              # View thanh toán, biên lai, lịch sử
│   │   ├── auth/               # View đăng nhập, đăng ký, hồ sơ
│   │   └── admin/              # Toàn bộ view quản trị
│   └── Core/
│       ├── App.php             # Bootstrapper và Autoloader PSR-4
│       ├── Router.php          # Điều hướng URL thân thiện & Query fallback
│       ├── Controller.php      # Base Controller, render view, validate CSRF
│       ├── Model.php           # Base Model với PDO Prepared Statements
│       ├── Auth.php            # Xác thực, RBAC, chống Brute-force
│       ├── Csrf.php            # Token CSRF bảo vệ Form và AJAX Header
│       ├── Session.php         # Quản lý Session an toàn, chống Session Fixation
│       ├── Validator.php       # Kiểm tra hợp thức dữ liệu Server-side
│       ├── Request.php         # Làm sạch request, Upload file ảnh an toàn
│       └── Response.php        # JSON Response, Redirect
├── config/
│   └── config.php              # Cấu hình CSDL, múi giờ, bảo mật cookie
├── routes/
│   └── web.php                 # Định nghĩa toàn bộ endpoint hệ thống
├── public/
│   ├── css/style.css           # Giao diện hiện đại, bóng bẩy
│   └── js/app.js               # jQuery AJAX giỏ hàng, tìm kiếm thời gian thực
├── uploads/                    # Thư mục lưu ảnh an toàn (.htaccess chặn thực thi PHP)
├── index.php                   # Front Controller
└── .htaccess                   # Rewrite URL thân thiện
```

### 2. Các cơ chế an toàn & kỹ thuật nâng cao đã tích hợp
1. **Xác thực (Authentication)**:
   - Mật khẩu mã hóa một chiều bằng hàm băm mạnh **BCRYPT** (`password_hash`, `password_verify`).
   - Chống tấn công dò quét mật khẩu (**Brute Force Protection**): Khóa tạm tài khoản 15 phút nếu nhập sai quá 5 lần.
   - Chống tấn công cố định phiên (**Session Fixation**): Sử dụng `session_regenerate_id(true)` khi đăng nhập.
2. **Phân quyền (Authorization / RBAC)**:
   - Phân biệt rõ vai trò `admin` và `customer`.
   - Toàn bộ trang quản trị `/admin/*` được bảo vệ bởi middleware `Auth::requireAdmin()`, trả về mã lỗi 403 Forbidden nếu người dùng không đủ quyền.
3. **Xử lý hợp thức (Validation & Sanitization)**:
   - Phía Client: HTML5 + Bootstrap form validation (`needs-validation`).
   - Phía Server: Lớp `Validator` kiểm tra kiểu dữ liệu, bắt buộc, độ dài, tính duy nhất (`unique:users,username`), email hợp lệ, số dương.
4. **Viết lại URL và định tuyến (URL Rewrite & Routing)**:
   - Hỗ trợ URL thân thiện qua `.htaccess` (ví dụ: `/products`, `/product/1`, `/cart`, `/checkout`, `/admin`).
   - Tích hợp cơ chế fallback tự động qua tham số `?r=...`, đảm bảo hệ thống chạy tốt trên mọi máy chủ Web (Apache XAMPP hoặc PHP CLI Server).
5. **Công nghệ AJAX (jQuery) & Bootstrap**:
   - Giao diện hiện đại sử dụng **Bootstrap 5.3**, responsive trên cả di động và máy tính.
   - AJAX thêm vào giỏ hàng không tải lại trang, cập nhật badge số lượng và hiển thị thông báo Toast.
   - AJAX cập nhật số lượng và xóa sản phẩm trong giỏ hàng tức thời.
   - AJAX tìm kiếm tức thì (**Live Search**) gợi ý sản phẩm ngay khi gõ từ khóa.
   - AJAX kiểm tra tên đăng nhập đã tồn tại trong form đăng ký.
   - Tích hợp **CKEditor 4** hỗ trợ soạn thảo mô tả laptop dạng rich text.
   - Tích hợp **Flatpickr** chọn ngày tháng.
6. **Phòng chống các tấn công phổ biến**:
   - **SQL Injection**: Sử dụng 100% PDO với **Prepared Statements** và ràng buộc tham số (`bindValue`), không ghép chuỗi SQL.
   - **XSS (Cross-Site Scripting)**: Dùng helper `e()` (`htmlspecialchars`) để làm sạch toàn bộ dữ liệu hiển thị.
   - **CSRF (Cross-Site Request Forgery)**: Tạo token CSRF cho từng phiên làm việc, chèn vào tất cả các form POST và tự động đính kèm qua header `X-CSRF-TOKEN` trong tất cả AJAX requests.
   - **Session Hijacking**: Cấu hình cookie an toàn (`HttpOnly=1`, `SameSite=Lax`).
   - **Tải lên file an toàn (Safe File Upload)**: Kiểm tra MIME type thực tế bằng `finfo`, kiểm tra đuôi mở rộng whitelist (`jpg`, `jpeg`, `png`, `webp`), đổi tên file ngẫu nhiên bằng `random_bytes()`, và file `.htaccess` trong thư mục `uploads/` chặn hoàn toàn việc thực thi script PHP.

### 3. Tài khoản thử nghiệm
- **Admin**: `admin` / `admin` (Toàn quyền quản trị Dashboard, Sản phẩm, Danh mục, Đơn hàng, Người dùng)
- **Khách hàng (Customer)**: `customer1` / `123456` (Xem sản phẩm, mua hàng, theo dõi đơn)


