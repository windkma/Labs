<?php
require_once __DIR__ . '/../models/User.php';

class AuthController {
    // Đăng nhập tài khoản
    public function login() {
        $error = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            check_csrf(); // Bảo vệ chống CSRF

            $username = trim($_POST['username'] ?? '');
            $password = $_POST['password'] ?? '';

            // Xử lý hợp thức (Validation cơ bản)
            if (empty($username) || empty($password)) {
                $error = 'Vui lòng nhập đầy đủ tên đăng nhập và mật khẩu!';
            } else {
                $user = findUserByUsername($username);

                // Xác thực mật khẩu bằng password_verify (BCRYPT)
                if ($user && password_verify($password, $user['password'])) {
                    // Chống Session Fixation bằng cách tạo mới ID phiên làm việc
                    session_regenerate_id(true);

                    // Lưu thông tin người dùng vào Session
                    $_SESSION['user'] = [
                        'id'       => $user['id'],
                        'username' => $user['username'],
                        'fullname' => $user['fullname'],
                        'role'     => $user['role']
                    ];

                    // Chuyển hướng theo vai trò (Phân quyền)
                    if ($user['role'] === 'admin') {
                        header('Location: index.php?url=admin');
                    } else {
                        header('Location: index.php');
                    }
                    exit;
                } else {
                    $error = 'Sai tên đăng nhập hoặc mật khẩu!';
                }
            }
        }
        require_once __DIR__ . '/../views/login.php';
    }

    // Đăng ký tài khoản
    public function register() {
        $error = '';
        $success = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            check_csrf();

            $username = trim($_POST['username'] ?? '');
            $fullname = trim($_POST['fullname'] ?? '');
            $password = $_POST['password'] ?? '';
            $repass   = $_POST['repassword'] ?? '';

            // Xử lý hợp thức dữ liệu (Validation)
            if (strlen($username) < 3) {
                $error = 'Tên đăng nhập phải chứa ít nhất 3 ký tự!';
            } elseif (empty($fullname)) {
                $error = 'Họ và tên không được để trống!';
            } elseif (strlen($password) < 6) {
                $error = 'Mật khẩu phải dài từ 6 ký tự trở lên!';
            } elseif ($password !== $repass) {
                $error = 'Mật khẩu nhập lại không khớp!';
            } elseif (findUserByUsername($username)) {
                $error = 'Tên đăng nhập này đã có người sử dụng!';
            } else {
                // Đăng ký và băm mật khẩu bằng BCRYPT
                registerUser($username, $password, $fullname);
                $success = 'Đăng ký thành công! Hãy đăng nhập ngay.';
            }
        }
        require_once __DIR__ . '/../views/register.php';
    }

    // Đăng xuất
    public function logout() {
        unset($_SESSION['user']);
        session_destroy();
        header('Location: index.php');
        exit;
    }
}
