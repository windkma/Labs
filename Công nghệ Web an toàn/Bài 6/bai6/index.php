<?php
/**
 * FRONT CONTROLLER & BỘ ĐỊNH TUYẾN (ROUTER) ĐƠN GIẢN
 * Điểm đón mọi yêu cầu và điều hướng đến Controller thích hợp
 */

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/controllers/ProductController.php';
require_once __DIR__ . '/controllers/CartController.php';
require_once __DIR__ . '/controllers/AuthController.php';
require_once __DIR__ . '/controllers/AdminController.php';

// Lấy đường dẫn (URL) từ request, mặc định là trang chủ 'home'
$url = trim($_GET['url'] ?? '', '/');

// Điều hướng theo mô hình MVC
switch ($url) {
    // 1. Phía Người dùng (End User)
    case '':
    case 'home':
        (new ProductController())->index();
        break;

    case 'detail':
        (new ProductController())->detail($_GET['id'] ?? 0);
        break;

    case 'search':
        (new ProductController())->searchAjax();
        break;

    // 2. Giỏ hàng & AJAX
    case 'cart':
        (new CartController())->index();
        break;

    case 'cart/add':
        (new CartController())->addAjax();
        break;

    case 'cart/remove':
        (new CartController())->remove($_GET['id'] ?? 0);
        break;

    case 'cart/clear':
        (new CartController())->clear();
        break;

    // 3. Xác thực tài khoản (Bcrypt + Brute force protection)
    case 'login':
        (new AuthController())->login();
        break;

    case 'register':
        (new AuthController())->register();
        break;

    case 'logout':
        (new AuthController())->logout();
        break;

    // 4. Phía Quản trị viên (Admin RBAC)
    case 'admin':
        (new AdminController())->index();
        break;

    case 'admin/product/add':
        (new AdminController())->addProduct();
        break;

    case 'admin/product/delete':
        (new AdminController())->deleteProduct($_POST['id'] ?? 0);
        break;

    case 'admin/user/toggle':
        (new AdminController())->toggleRole($_POST['id'] ?? 0);
        break;

    // 404 Không tìm thấy trang
    default:
        http_response_code(404);
        echo "<h2 style='text-align:center; margin-top:50px;'>404 - Không tìm thấy trang! <a href='index.php'>Về trang chủ</a></h2>";
        break;
}
