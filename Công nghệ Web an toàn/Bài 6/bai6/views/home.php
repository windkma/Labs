<?php
require_once __DIR__ . '/header.php';
$products = $products ?? [];
?>

<div class="row mb-4">
    <div class="col-md-6 mx-auto">
        <!-- Ô tìm kiếm trực tiếp bằng AJAX -->
        <label class="form-label fw-bold">🔍 Tìm kiếm Laptop (AJAX Live Search):</label>
        <input type="text" id="search-box" class="form-control" placeholder="Gõ tên máy hoặc cấu hình để tìm nhanh..." autocomplete="off">
        <div id="search-results" class="list-group position-absolute shadow mt-1" style="max-width: 500px; z-index: 1000; display: none;"></div>
    </div>
</div>

<h3 class="mb-3">Danh Sách Laptop Hiện Có</h3>

<div class="row g-3">
    <?php foreach ($products as $p): ?>
        <div class="col-md-6 col-lg-3">
            <div class="card h-100 shadow-sm">
                <div class="text-center p-2 bg-white" style="height: 140px; display: flex; align-items: center; justify-content: center;">
                    <img src="../img/<?php echo e($p['image']); ?>" alt="<?php echo e($p['name']); ?>" style="max-height: 120px; max-width: 100%; object-fit: contain;" onerror="this.onerror=null; this.src='../img/avatar.png';">
                </div>
                <div class="card-body d-flex flex-direction-column flex-column">
                    <h6 class="card-title fw-bold">
                        <a href="index.php?url=detail&id=<?php echo $p['id']; ?>" class="text-dark text-decoration-none">
                            <?php echo e($p['name']); ?>
                        </a>
                    </h6>
                    <div class="text-danger fw-bold mb-2">
                        <?php echo format_price($p['price']); ?>
                    </div>
                    <div class="small text-muted mb-3">
                        Hãng: <?php echo e($p['category_name'] ?? 'Khác'); ?> | Kho: <b><?php echo (int)$p['sl']; ?> máy</b>
                    </div>
                    
                    <div class="mt-auto d-flex gap-1">
                        <a href="index.php?url=detail&id=<?php echo $p['id']; ?>" class="btn btn-outline-secondary btn-sm flex-grow-1">Xem</a>
                        <button type="button" class="btn btn-danger btn-sm" onclick="addToCartAjax(<?php echo $p['id']; ?>)">
                            + Giỏ hàng
                        </button>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<?php require_once __DIR__ . '/footer.php'; ?>
