-- Database: laptop_shop
CREATE DATABASE IF NOT EXISTS laptop_shop DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE laptop_shop;

-- 1. Bảng categories (Danh mục / Hãng sản xuất)
CREATE TABLE IF NOT EXISTS categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE,
    description VARCHAR(255) NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 2. Bảng users (Quản trị viên & Khách hàng có phân quyền)
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    fullname VARCHAR(100) NOT NULL,
    email VARCHAR(100) NULL,
    phone VARCHAR(20) NULL,
    birthday DATE NULL,
    address VARCHAR(255) NULL,
    image VARCHAR(255) DEFAULT 'avatar.png',
    role ENUM('admin', 'customer') NOT NULL DEFAULT 'customer',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 3. Bảng products (Sản phẩm laptop)
CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    category_id INT NULL,
    price DECIMAL(12, 2) NOT NULL DEFAULT 0,
    image VARCHAR(255) DEFAULT 'laptop.png',
    description MEDIUMTEXT NULL,
    sl INT NOT NULL DEFAULT 10,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 4. Bảng orders (Đơn hàng)
CREATE TABLE IF NOT EXISTS orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NULL,
    customer_name VARCHAR(100) NOT NULL,
    customer_phone VARCHAR(20) NOT NULL,
    customer_address VARCHAR(255) NOT NULL,
    customer_note TEXT NULL,
    total_amount DECIMAL(12, 2) NOT NULL DEFAULT 0,
    payment_method VARCHAR(50) DEFAULT 'cod',
    status ENUM('pending', 'processing', 'completed', 'cancelled') NOT NULL DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 5. Bảng order_items (Chi tiết từng món hàng trong đơn)
CREATE TABLE IF NOT EXISTS order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    product_id INT NULL,
    product_name VARCHAR(255) NOT NULL,
    price DECIMAL(12, 2) NOT NULL,
    quantity INT NOT NULL DEFAULT 1,
    subtotal DECIMAL(12, 2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Nạp dữ liệu mẫu danh mục
INSERT INTO categories (id, name, description) VALUES
(1, 'Laptop DELL', 'Dòng laptop văn phòng và gaming bền bỉ hàng đầu'),
(2, 'Laptop HP', 'Thiết kế sang trọng, hiệu năng vượt trội'),
(3, 'Laptop ASUS', 'Đột phá công nghệ màn hình OLED và gaming ROG'),
(4, 'Laptop LENOVO', 'Bàn phím gõ êm, dòng ThinkPad huyền thoại'),
(5, 'Laptop ACER', 'Cấu hình cao, tối ưu chi phí cho sinh viên'),
(6, 'Laptop MACBOOK', 'Hệ điều hành macOS mượt mà, thời lượng pin cả ngày'),
(7, 'Laptop MSI', 'Chuyên biệt cho game thủ và đồ họa chuyên nghiệp')
ON DUPLICATE KEY UPDATE name=VALUES(name);

-- Nạp dữ liệu mẫu người dùng (Mật khẩu 'admin' và '123456' được băm bcrypt)
-- 'admin' (password: admin) -> role: admin
-- 'customer1' (password: 123456) -> role: customer
INSERT INTO users (id, username, password, fullname, email, phone, birthday, address, role, image) VALUES
(1, 'admin', '$2y$10$nptvV5e3l/fL/k8K2eXbse4UqZtVf1bN/gB2pWjP9e2Z5rBvyzGsm', 'Quản Trị Viên Hệ Thống', 'admin@laptopshop.vn', '0987654321', '1995-05-10', 'Học viện Kỹ thuật Mật mã, Hà Nội', 'admin', 'avatar.png'),
(2, 'customer1', '$2y$10$wT55h/z2qX4BfZ3vNq3hge2x099mKxS3f2h7v9p9zGq0v0pW8f7m6', 'Nguyễn Văn An', 'an.nguyen@gmail.com', '0912345678', '2001-08-20', 'Thanh Xuân, Hà Nội', 'customer', 'avatar.png')
ON DUPLICATE KEY UPDATE fullname=VALUES(fullname);

-- Nạp dữ liệu mẫu laptop phong phú
INSERT INTO products (id, name, category_id, price, image, description, sl) VALUES
(1, 'Dell XPS 13 Plus 9320 (Core i7-1360P, 16GB, 512GB)', 1, 32900000, 'laptop.png', '<h3>Dell XPS 13 Plus đỉnh cao công nghệ</h3><p>Màn hình 13.4 inch 3.5K OLED rực rỡ, CPU Intel Core i7 thế hệ 13, khung nhôm nguyên khối siêu nhẹ 1.26kg, bàn phím tràn cạnh hiện đại.</p>', 15),
(2, 'Dell Vostro 5410 (Core i5-11320H, 8GB, 512GB)', 1, 14990000, 'laptop.png', '<h3>Dell Vostro bền bỉ cho doanh nhân</h3><p>Bộ vi xử lý Intel Core i5 mạnh mẽ, hỗ trợ nâng cấp RAM dễ dàng, bảo mật vân tay 1 chạm.</p>', 8),
(3, 'HP Envy x360 2-in-1 (Ryzen 7 7730U, 16GB, 512GB)', 2, 21500000, 'laptop.png', '<h3>HP Envy xoay gập 360 độ linh hoạt</h3><p>Màn hình cảm ứng OLED kèm bút stylus, vỏ nhôm kim loại cao cấp, hệ thống loa Bang & Olufsen sống động.</p>', 12),
(4, 'HP Pavilion 15 (Core i5-1235U, 16GB, 512GB)', 2, 13800000, 'laptop.png', '<h3>Laptop sinh viên học tập làm việc xuất sắc</h3><p>Màn hình 15.6 inch FHD chống chói, bàn phím số tiện lợi nhập liệu, sạc nhanh 50% trong 45 phút.</p>', 20),
(5, 'Asus Zenbook 14 OLED UX3405 (Core Ultra 5 125H)', 3, 23990000, 'laptop.png', '<h3>Chuẩn AI PC mới nhất với chip Intel Ultra</h3><p>Màn hình Lumina OLED 3K 120Hz sắc nét tuyệt đối, pin 75Wh dùng cả ngày, chuẩn độ bền quân đội Mỹ MIL-STD-810H.</p>', 10),
(6, 'Asus ROG Strix G16 (Core i7-13650HX, RTX 4060)', 3, 35500000, 'laptop.png', '<h3>Chiến binh gaming đỉnh cao</h3><p>Card đồ họa rời NVIDIA GeForce RTX 4060 8GB, tản nhiệt 3 quạt buồng hơi, tần số quét 240Hz siêu mượt.</p>', 5),
(7, 'MacBook Air M2 13.6 inch (8GB RAM, 256GB SSD)', 6, 24500000, 'laptop.png', '<h3>Thiết kế mỏng nhẹ huyền thoại của Apple</h3><p>Chip Apple M2 mạnh mẽ không cần quạt tản nhiệt, thời lượng pin lên đến 18 tiếng, màn hình Liquid Retina tuyệt đẹp.</p>', 14),
(8, 'Lenovo ThinkPad E14 Gen 5 (Core i7-1355U, 16GB)', 4, 20900000, 'laptop.png', '<h3>Bàn phím trứ danh, độ bảo mật doanh nghiệp</h3><p>Bảo mật chip TPM 2.0, nắp che camera vật lý ThinkShutter, bàn phím chống tràn nước trứ danh.</p>', 7),
(9, 'Acer Swift Go 14 (Core i5-13500H, 16GB, 512GB OLED)', 5, 17200000, 'laptop.png', '<h3>Laptop mỏng nhẹ màn OLED giá tốt nhất</h3><p>Độ phân giải 2.8K 90Hz, 100% sRGB, vỏ kim loại sang trọng, webcam 1440p QHD sắc nét.</p>', 11)
ON DUPLICATE KEY UPDATE name=VALUES(name);

-- Nạp mẫu 1 đơn hàng demo
INSERT INTO orders (id, user_id, customer_name, customer_phone, customer_address, customer_note, total_amount, payment_method, status) VALUES
(1, 2, 'Nguyễn Văn An', '0912345678', 'Số 141 Chiến Thắng, Thanh Trì, Hà Nội', 'Giao trong giờ hành chính', 24500000, 'cod', 'completed')
ON DUPLICATE KEY UPDATE id=id;

INSERT INTO order_items (id, order_id, product_id, product_name, price, quantity, subtotal) VALUES
(1, 1, 7, 'MacBook Air M2 13.6 inch (8GB RAM, 256GB SSD)', 24500000, 1, 24500000)
ON DUPLICATE KEY UPDATE id=id;
