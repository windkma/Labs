<?php
require_once __DIR__ . '/../models/Product.php';
require_once __DIR__ . '/../models/User.php';

class AdminController {
    // Hàm bảo vệ phân quyền: Chỉ tài khoản Admin mới được chạy
    private function checkAdmin() {
        if (empty($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            http_response_code(403);
            die("<div style='text-align:center; padding:50px; font-family:sans-serif;'>
                <h1 style='color:red;'>403 - Cấm truy cập!</h1>
                <p>Bạn không có quyền quản trị viên để vào khu vực này.</p>
                <a href='index.php'>&laquo; Về Trang Chủ</a>
            </div>");
        }
    }

    // Hiển thị bảng điều khiển quản trị
    public function index() {
        $this->checkAdmin();
        $products = getAllProducts();
        $categories = getAllCategories();
        $users = getAllUsers();
        require_once __DIR__ . '/../views/admin.php';
    }

    // Thêm mới sản phẩm laptop
    public function addProduct() {
        $this->checkAdmin();
        check_csrf();

        $name = trim($_POST['name'] ?? '');
        $categoryId = (int)($_POST['category_id'] ?? 1);
        $price = (float)($_POST['price'] ?? 0);
        $sl = (int)($_POST['sl'] ?? 1);
        $description = trim($_POST['description'] ?? '');

        // Xử lý hợp thức (Validation)
        if (!empty($name) && $price > 0) {
            addProduct($name, $categoryId, $price, $sl, $description);
        }

        header('Location: index.php?url=admin');
        exit;
    }

    // Xóa sản phẩm laptop
    public function deleteProduct($id) {
        $this->checkAdmin();
        check_csrf();
        deleteProduct($id);
        header('Location: index.php?url=admin');
        exit;
    }

    // Chuyển đổi vai trò người dùng (Phân quyền Admin / Customer)
    public function toggleRole($id) {
        $this->checkAdmin();
        check_csrf();

        // Không cho phép tự tước quyền của chính mình
        if ((int)$id !== (int)$_SESSION['user']['id']) {
            toggleUserRole($id);
        }

        header('Location: index.php?url=admin');
        exit;
    }
}
