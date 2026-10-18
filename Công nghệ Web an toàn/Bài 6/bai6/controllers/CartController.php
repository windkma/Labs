<?php
require_once __DIR__ . '/../models/Product.php';

class CartController {
    // Xem trang giỏ hàng
    public function index() {
        $cart = $_SESSION['cart'] ?? [];
        require_once __DIR__ . '/../views/cart.php';
    }

    // Thêm sản phẩm vào giỏ hàng bằng AJAX (Không tải lại trang)
    public function addAjax() {
        check_csrf(); // Kiểm tra CSRF token

        $productId = (int)($_POST['product_id'] ?? 0);
        $product = getProductById($productId);

        if ($product) {
            if (!isset($_SESSION['cart'])) {
                $_SESSION['cart'] = [];
            }

            if (isset($_SESSION['cart'][$productId])) {
                $_SESSION['cart'][$productId]['qty']++;
            } else {
                $_SESSION['cart'][$productId] = [
                    'id'    => $product['id'],
                    'name'  => $product['name'],
                    'price' => $product['price'],
                    'image' => $product['image'],
                    'qty'   => 1
                ];
            }

            $totalCount = 0;
            foreach ($_SESSION['cart'] as $item) {
                $totalCount += $item['qty'];
            }

            header('Content-Type: application/json; charset=utf-8');
            echo json_encode(['success' => true, 'total' => $totalCount, 'name' => $product['name']]);
            exit;
        }

        echo json_encode(['success' => false, 'message' => 'Sản phẩm không tồn tại']);
        exit;
    }

    // Xóa một món hàng
    public function remove($id) {
        $id = (int)$id;
        unset($_SESSION['cart'][$id]);
        header('Location: index.php?url=cart');
        exit;
    }

    // Làm trống toàn bộ giỏ
    public function clear() {
        unset($_SESSION['cart']);
        header('Location: index.php?url=cart');
        exit;
    }
}
