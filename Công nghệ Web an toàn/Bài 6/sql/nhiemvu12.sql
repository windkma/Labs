CREATE DATABASE IF NOT EXISTS quanlysinhvien_nv12 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE quanlysinhvien_nv12;

-- 1. Bảng classes
CREATE TABLE IF NOT EXISTS classes (
    ID VARCHAR(10) PRIMARY KEY,
    ClassName VARCHAR(50) NOT NULL,
    ClassDescription VARCHAR(255),
    NumOfStudents INT DEFAULT 0
);

-- 2. Bảng students
CREATE TABLE IF NOT EXISTS students (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    StudentName VARCHAR(50) NOT NULL,
    StudentGender VARCHAR(10),
    StudentAddress VARCHAR(150),
    StudentImage VARCHAR(100),
    ClassID VARCHAR(10),
    FOREIGN KEY (ClassID) REFERENCES classes(ID) ON DELETE CASCADE
);

-- 3. Dữ liệu mẫu bảng classes
INSERT INTO classes (ID, ClassName, ClassDescription, NumOfStudents) VALUES
('PHP001', 'PHP001', 'Lớp học lập trình PHP cơ bản', 30),
('0908M', '0908M', 'Lớp 0908M Chuyên ngành', 35),
('0908L', '0908L', 'Lớp 0908L Chuyên ngành', 32),
('09A3G', '09A3G', 'Lớp 09A3G', 28),
('09A1H', '09A1H', 'Lớp 09A1H', 30)
ON DUPLICATE KEY UPDATE ID=ID;

-- 4. Dữ liệu mẫu bảng students
INSERT INTO students (StudentName, StudentGender, StudentAddress, StudentImage, ClassID) VALUES
('Nguyen Trai', 'Nam', 'Hai Duong', 'avatar.png', 'PHP001'),
('Nguyen Du', 'Nam', 'Hue', 'avatar.png', 'PHP001'),
('Ho Xuan Huong', 'Nu', 'Viet Nam', 'avatar.png', 'PHP001'),
('Pham Minh', 'Nam', 'Ha Noi', 'avatar.png', '0908M'),
('Le Loi', 'Nam', 'Thanh Hoa', 'avatar.png', '0908M'),
('Tran Hung Dao', 'Nam', 'Nam Dinh', 'avatar.png', '0908L')
ON DUPLICATE KEY UPDATE ID=ID;