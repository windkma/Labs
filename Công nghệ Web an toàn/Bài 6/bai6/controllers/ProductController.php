<?php
require_once __DIR__ . '/../models/Product.php';

class ProductController {
    // Hiển thị trang chủ danh sách laptop
    public function index() {
        $products = getAllProducts();
        require_once __DIR__ . '/../views/home.php';
    }

    // Xem chi tiết một laptop
    public function detail($id) {
        $product = getProductById($id);
        if (!$product) {
            header('Location: index.php');
            exit;
        }
        require_once __DIR__ . '/../views/detail.php';
    }

    // Xử lý tìm kiếm qua AJAX (trả về dữ liệu JSON)
    public function searchAjax() {
        $keyword = trim($_GET['q'] ?? '');
        $results = !empty($keyword) ? searchProducts($keyword) : [];
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($results);
        exit;
    }
}
