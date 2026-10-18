<?php
// Bật session với cờ bảo mật Cookie (chống đánh cắp session qua Javascript)
if (session_status() === PHP_SESSION_NONE) {
    ini_set('session.cookie_httponly', 1);
    ini_set('session.cookie_samesite', 'Lax');
    session_start();
}

// Cấu hình CSDL MySQL
define('DB_HOST', '127.0.0.1');
define('DB_NAME', 'laptop_shop');
define('DB_USER', 'root');
define('DB_PASS', '');

// Kết nối CSDL bằng PDO (chống SQL Injection)
try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4", DB_USER, DB_PASS, [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false // Dùng Prepared Statements thực thụ
    ]);
} catch (PDOException $e) {
    // Nếu chưa có CSDL, tự động tạo và nạp dữ liệu mẫu
    $serverPdo = new PDO("mysql:host=" . DB_HOST . ";charset=utf8mb4", DB_USER, DB_PASS);
    $serverPdo->exec("CREATE DATABASE IF NOT EXISTS `" . DB_NAME . "` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4", DB_USER, DB_PASS, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
}

// Tự động kiểm tra và tạo bảng nếu chưa có
$pdo->exec("
    CREATE TABLE IF NOT EXISTS categories (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL
    );
    CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(50) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        fullname VARCHAR(100) NOT NULL,
        role VARCHAR(20) NOT NULL DEFAULT 'customer'
    );
    CREATE TABLE IF NOT EXISTS products (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        category_id INT NULL,
        price DECIMAL(12,2) NOT NULL,
        image VARCHAR(255) DEFAULT 'laptop.png',
        description TEXT,
        sl INT NOT NULL DEFAULT 10
    );
");

// Tạo sẵn tài khoản mẫu nếu bảng users trống (mật khẩu được băm BCRYPT)
$checkUser = $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();
if ($checkUser == 0) {
    $hashAdmin = password_hash('admin', PASSWORD_BCRYPT);
    $hashCustomer = password_hash('123456', PASSWORD_BCRYPT);
    $stmt = $pdo->prepare("INSERT INTO users (username, password, fullname, role) VALUES (?, ?, ?, ?)");
    $stmt->execute(['admin', $hashAdmin, 'Quản Trị Viên', 'admin']);
    $stmt->execute(['customer1', $hashCustomer, 'Khách Hàng An', 'customer']);
}

// Tạo sẵn sản phẩm mẫu nếu bảng products trống
$checkProduct = $pdo->query("SELECT COUNT(*) FROM products")->fetchColumn();
if ($checkProduct == 0) {
    $pdo->exec("
        INSERT INTO categories (id, name) VALUES (1, 'Dell'), (2, 'HP'), (3, 'Asus'), (4, 'MacBook');
        INSERT INTO products (name, category_id, price, image, description, sl) VALUES 
        ('Dell XPS 13 (Core i7, 16GB, 512GB)', 1, 28900000, 'laptop.png', 'Màn hình 13.4 inch FHD+, vỏ nhôm siêu nhẹ 1.2kg, pin 12 tiếng.', 10),
        ('HP Pavilion 15 (Core i5, 8GB, 512GB)', 2, 14500000, 'laptop.png', 'Laptop học tập văn phòng tốt nhất trong tầm giá.', 15),
        ('Asus ROG Strix G16 (Core i7, RTX 4060)', 3, 33500000, 'laptop.png', 'Laptop gaming màn hình 240Hz, card đồ họa rời cực mạnh.', 5),
        ('MacBook Air M2 (8GB RAM, 256GB SSD)', 4, 23900000, 'laptop.png', 'Chip Apple M2 mát mẻ, pin dùng cả ngày, màn Liquid Retina.', 8);
    ");
}

// 1. Chống tấn công XSS: Hàm chuyển đổi ký tự nguy hiểm trước khi in ra HTML
function e($string) {
    return htmlspecialchars((string)$string, ENT_QUOTES, 'UTF-8');
}

// 2. Chống tấn công CSRF: Sinh token ngẫu nhiên lưu trong Session
function csrf_token() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(16));
    }
    return $_SESSION['csrf_token'];
}

// Tạo thẻ input ẩn chứa token cho Form POST
function csrf_field() {
    return '<input type="hidden" name="csrf_token" value="' . csrf_token() . '">';
}

// Kiểm tra token CSRF khi nhận Form hoặc AJAX
function check_csrf() {
    $token = $_POST['csrf_token'] ?? $_SERVER['HTTP_X_CSRF_TOKEN'] ?? '';
    if (empty($token) || $token !== $_SESSION['csrf_token']) {
        die("<h3 style='color:red;'>Lỗi bảo mật: CSRF Token không hợp lệ!</h3><a href='index.php'>Quay lại</a>");
    }
}

// Định dạng tiền tệ VNĐ
function format_price($number) {
    return number_format((float)$number, 0, ',', '.') . ' đ';
}
