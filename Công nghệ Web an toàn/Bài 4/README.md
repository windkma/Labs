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

