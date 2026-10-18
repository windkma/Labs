CREATE DATABASE IF NOT EXISTS laptop_shop DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE laptop_shop;

-- 1. Bang Categories (Danh muc laptop)
CREATE TABLE IF NOT EXISTS categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL
);

-- 2. Bang Users (Quan tri vien & Khach hang)
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(100) NOT NULL,
    fullname VARCHAR(100) NOT NULL,
    birthday DATE,
    address VARCHAR(255),
    image VARCHAR(255) DEFAULT 'avatar.png'
);

-- 3. Bang Products (San pham laptop)
CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    category_id INT,
    price DECIMAL(12, 2) NOT NULL,
    image VARCHAR(255) DEFAULT 'laptop.png',
    description TEXT,
    sl INT NOT NULL DEFAULT 10,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL
);

-- Du lieu mau bang Categories
INSERT INTO categories (id, name) VALUES 
(1, 'Laptop DELL'),
(2, 'Laptop HP-COMPAQ'),
(3, 'Laptop SONY VAIO'),
(4, 'Laptop LENOVO'),
(5, 'Laptop ACER'),
(6, 'Laptop ASUS'),
(7, 'Laptop MACBOOK')
ON DUPLICATE KEY UPDATE id=id;

-- Du lieu mau bang Users (Mat khau demo: admin)
INSERT INTO users (id, username, password, fullname, birthday, address, image) VALUES 
(1, 'admin', 'admin', 'Nguyen Quoc', '1995-05-10', 'Ha Noi', 'avatar.png')
ON DUPLICATE KEY UPDATE id=id;

-- Du lieu mau bang Products
INSERT INTO products (id, name, category_id, price, image, description, sl) VALUES
(1, 'Laptop Dell Vostro 1014 (Core 2 Duo T6670)', 1, 6499000, 'laptop.png', '<p>CPU Intel Core 2 Duo T6670 2.2GHz, Ram 2GB, HDD 500GB, Man hinh 14 inch.</p>', 10),
(2, 'Dell Inspiron 54050 (Intel Pentium P6100)', 1, 9999000, 'laptop.png', '<p>Intel Pentium P6100 2.0GHz, 2GB DDR3, HDD 500GB, ATI Radeon HD 5470 1GB.</p>', 10),
(3, 'HP ProBook 450 G8', 2, 14500000, 'laptop.png', '<p>Intel Core i5 Gen 11, Ram 8GB, SSD 512GB, Man hinh 15.6 inch FHD.</p>', 10),
(4, 'MacBook Air M1 2020', 7, 18200000, 'laptop.png', '<p>Chip Apple M1, Ram 8GB, SSD 256GB, Retina 13.3 inch.</p>', 10)
ON DUPLICATE KEY UPDATE id=id;
