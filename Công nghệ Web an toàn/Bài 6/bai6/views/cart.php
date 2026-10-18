<?php require_once __DIR__ . '/header.php'; ?>

<h3>🛒 Giỏ Hàng Của Bạn</h3>

<?php if (empty($cart)): ?>
    <div class="alert alert-info">Giỏ hàng của bạn đang trống! <a href="index.php">Xem thêm laptop</a></div>
<?php else: ?>
    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle bg-white">
            <thead class="table-dark">
                <tr>
                    <th>Sản phẩm</th>
                    <th>Đơn giá</th>
                    <th style="width: 100px;">Số lượng</th>
                    <th>Thành tiền</th>
                    <th class="text-center">Xóa</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $total = 0;
                foreach ($cart as $id => $item): 
                    $itemQty = (int)($item['qty'] ?? $item['quantity'] ?? 1);
                    $subtotal = $item['price'] * $itemQty;
                    $total += $subtotal;
                ?>
                    <tr>
                        <td><b><?php echo e($item['name']); ?></b></td>
                        <td><?php echo format_price($item['price']); ?></td>
                        <td><?php echo $itemQty; ?></td>
                        <td class="fw-bold text-danger"><?php echo format_price($subtotal); ?></td>
                        <td class="text-center">
                            <a href="index.php?url=cart/remove&id=<?php echo $id; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Xóa sản phẩm này?')">Xóa</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="3" class="text-end">Tổng tiền thanh toán:</th>
                    <th colspan="2" class="text-danger fs-5"><?php echo format_price($total); ?></th>
                </tr>
            </tfoot>
        </table>
    </div>

    <div class="d-flex justify-content-between mt-3">
        <a href="index.php?url=cart/clear" class="btn btn-outline-danger" onclick="return confirm('Xóa sạch giỏ hàng?')">Làm trống giỏ hàng</a>
        <button type="button" class="btn btn-success btn-lg" onclick="alert('Cảm ơn bạn! Đơn hàng trị giá <?php echo format_price($total); ?> đã được ghi nhận thành công.')">
            ✅ Đặt Hàng Ngay
        </button>
    </div>
<?php endif; ?>

<?php require_once __DIR__ . '/footer.php'; ?>
