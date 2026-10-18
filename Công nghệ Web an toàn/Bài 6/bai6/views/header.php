<?php
$cartCount = 0;
if (!empty($_SESSION['cart']) && is_array($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $item) {
        $cartCount += (int)($item['qty'] ?? $item['quantity'] ?? 1);
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Web Bán Laptop - Bài Tập 6 MVC</title>
    <!-- Nhúng CSS Bootstrap 5 (Không cần viết CSS thủ công phức tạp) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <!-- Thanh Menu Điều Hướng (Navbar) -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container">
            <a class="navbar-brand fw-bold" href="index.php">💻 LaptopStore (MVC)</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a class="nav-link" href="index.php">Trang Chủ</a></li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?url=cart">
                            🛒 Giỏ Hàng (<span id="cart-count" class="badge bg-danger"><?php echo $cartCount; ?></span>)
                        </a>
                    </li>
                </ul>

                <ul class="navbar-nav ms-auto">
                    <?php if (!empty($_SESSION['user'])): ?>
                        <li class="nav-item">
                            <span class="nav-link text-info">
                                Chào <b><?php echo e($_SESSION['user']['fullname']); ?></b> (<?php echo e($_SESSION['user']['role']); ?>)
                            </span>
                        </li>
                        <?php if ($_SESSION['user']['role'] === 'admin'): ?>
                            <li class="nav-item"><a class="nav-link text-warning fw-bold" href="index.php?url=admin">⚙️ Quản Trị</a></li>
                        <?php endif; ?>
                        <li class="nav-item"><a class="nav-link" href="index.php?url=logout">Đăng Xuất</a></li>
                    <?php else: ?>
                        <li class="nav-item"><a class="nav-link" href="index.php?url=login">Đăng Nhập</a></li>
                        <li class="nav-item"><a class="nav-link" href="index.php?url=register">Đăng Ký</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Khung chứa nội dung chính -->
    <div class="container">
