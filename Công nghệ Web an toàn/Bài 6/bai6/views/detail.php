<?php require_once __DIR__ . '/header.php'; ?>

<div class="card p-4 shadow-sm">
    <div class="row">
        <div class="col-md-5 text-center">
            <img src="../img/<?php echo e($product['image']); ?>" alt="<?php echo e($product['name']); ?>" class="img-fluid" style="max-height: 250px;" onerror="this.onerror=null; this.src='../img/avatar.png';">
        </div>
        <div class="col-md-7">
            <h2><?php echo e($product['name']); ?></h2>
            <div class="text-danger fs-3 fw-bold my-2"><?php echo format_price($product['price']); ?></div>
            <p><b>Hãng sản xuất:</b> <?php echo e($product['category_name'] ?? 'Khác'); ?></p>
            <p><b>Tình trạng kho:</b> <?php echo (int)$product['sl']; ?> máy có sẵn</p>

            <div class="my-3">
                <button type="button" class="btn btn-danger btn-lg" onclick="addToCartAjax(<?php echo $product['id']; ?>)">
                    🛒 Thêm Vào Giỏ Hàng (AJAX)
                </button>
            </div>

            <hr>
            <h5>Mô Tả & Cấu Hình:</h5>
            <div class="text-secondary"><?php echo e($product['description']); ?></div>
            <br>
            <a href="index.php">&laquo; Quay lại danh sách laptop</a>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/footer.php'; ?>
