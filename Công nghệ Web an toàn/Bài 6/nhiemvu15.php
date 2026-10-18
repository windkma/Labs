<?php
$pageTitle = 'Nhiệm vụ 15 - Giỏ hàng';
$pageClass = 'task-15';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

require_once __DIR__ . '/includes/database.php';
$conn = connect_database('laptop_shop', 'sql/laptop_shop.sql');

$action = $_GET['action'] ?? '';

// Thêm sản phẩm vào giỏ
if ($action === 'add' && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    if (isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id]['quantity']++;
    } else {
        $rs = mysqli_query($conn, "SELECT * FROM products WHERE id = $id");
        if ($row = mysqli_fetch_assoc($rs)) {
            $_SESSION['cart'][$id] = [
                'name' => $row['name'],
                'price' => $row['price'],
                'quantity' => 1
            ];
        }
    }
    header("Location: nhiemvu15.php");
    exit();
}
// Cập nhật số lượng
if (isset($_POST['btnUpdateCart'])) {
    foreach ($_POST['qty'] as $id => $qty) {
        $qty = (int)$qty;
        if ($qty <= 0) {
            unset($_SESSION['cart'][$id]);
        } else {
            $_SESSION['cart'][$id]['quantity'] = $qty;
        }
    }
    header("Location: nhiemvu15.php");
    exit();
}

// Xóa 1 sản phẩm
if ($action === 'delete' && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    unset($_SESSION['cart'][$id]);
    header("Location: nhiemvu15.php");
    exit();
}

// Xóa sạch giỏ hàng
if ($action === 'clear') {
    unset($_SESSION['cart']);
    header("Location: nhiemvu15.php");
    exit();
}

// Thanh toán: trừ số lượng trong CSDL
if ($action === 'checkout' && !empty($_SESSION['cart'])) {
    $errors = [];
    // Kiểm tra tồn kho trước
    foreach ($_SESSION['cart'] as $id => $item) {
        $id = (int)$id;
        $qty = (int)$item['quantity'];
        $rs = mysqli_query($conn, "SELECT sl FROM products WHERE id = $id");
        $row = mysqli_fetch_assoc($rs);
        if (!$row || $row['sl'] < $qty) {
            $errors[] = htmlspecialchars($item['name']) . ' không đủ tồn kho (còn ' . (int)($row['sl'] ?? 0) . ' sp).';
        }
    }
    if (empty($errors)) {
        // Trừ số lượng
        foreach ($_SESSION['cart'] as $id => $item) {
            $id = (int)$id;
            $qty = (int)$item['quantity'];
            mysqli_query($conn, "UPDATE products SET sl = GREATEST(sl - $qty, 0) WHERE id = $id");
        }
        unset($_SESSION['cart']);
        $_SESSION['checkout_success'] = true;
    } else {
        $_SESSION['checkout_errors'] = $errors;
    }
    header("Location: nhiemvu15.php");
    exit();
}

include "includes/header.php";
?>

<style>
.cart-table { width: 100%; border-collapse: collapse; margin-top: 15px; font-size: 13px; }
.cart-table th, .cart-table td { border: 1px solid #ccc; padding: 8px; text-align: center; }
.cart-table th { background: #f0f0f0; }
.btn-c { padding: 5px 12px; background: #2196F3; color: white; border: none; border-radius: 3px; cursor: pointer; text-decoration: none; font-size: 12px; }
.btn-c-red { background: #d32f2f; }
.btn-c-gray { background: #777; }
</style>

<h3>Nhiệm vụ 15: Chức Năng Giỏ Hàng (Shopping Cart)</h3>

<?php if (empty($_SESSION['cart'])): ?>
    <?php if (!empty($_SESSION['checkout_success'])): unset($_SESSION['checkout_success']); ?>
        <div style="padding: 20px; text-align: center; background: #e8f5e9; border: 1px solid #a5d6a7; margin-top: 15px; border-radius: 4px;">
            <p style="color: #2e7d32; font-size: 16px; font-weight: bold;">&#127881; &#272;&#7863;t h&#224;ng th&#224;nh c&#244;ng! C&#7843;m &#417;n b&#7841;n &#273;&#227; mua s&#7855;m.</p>
            <br>
            <a href="nhiemvu13.php" class="btn-c">&#171; Ti&#7871;p t&#7909;c mua s&#7855;m</a>
        </div>
    <?php else: ?>
    <div style="padding: 25px; text-align: center; background: #fafafa; border: 1px solid #ddd; margin-top: 15px;">
        <p>Giỏ hàng của bạn đang trống!</p>
        <br>
        <a href="nhiemvu13.php" class="btn-c">&laquo; Mua sắm laptop tại Nhiệm vụ 13</a>
    </div>
    <?php endif; ?>
<?php else: ?>
    <form method="POST" action="nhiemvu15.php">
        <table class="cart-table">
            <tr>
                <th style="width: 8%;">STT</th>
                <th style="text-align: left;">Tên sản phẩm</th>
                <th style="width: 18%;">Đơn giá</th>
                <th style="width: 15%;">Số lượng</th>
                <th style="width: 18%;">Thành tiền</th>
                <th style="width: 10%;">Xóa</th>
            </tr>
            <?php
            $stt = 1;
            $total = 0;
            foreach ($_SESSION['cart'] as $id => $item):
                $subtotal = $item['price'] * $item['quantity'];
                $total += $subtotal;
            ?>
                <tr>
                    <td><?php echo $stt++; ?></td>
                    <td style="text-align: left;"><b><?php echo htmlspecialchars($item['name']); ?></b></td>
                    <td><?php echo number_format($item['price'], 0, ',', '.'); ?> đ</td>
                    <td>
                        <input type="number" name="qty[<?php echo $id; ?>]" value="<?php echo $item['quantity']; ?>" min="1" style="width: 50px; text-align: center;">
                    </td>
                    <td style="color:#d32f2f; font-weight:bold;"><?php echo number_format($subtotal, 0, ',', '.'); ?> đ</td>
                    <td>
                        <a href="nhiemvu15.php?action=delete&id=<?php echo $id; ?>" style="color: red;" onclick="return confirm('Bỏ sản phẩm này?')">✖</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            <tr>
                <td colspan="4" style="text-align: right; font-weight: bold;">Tổng tiền thanh toán:</td>
                <td colspan="2" style="color:#d32f2f; font-weight:bold; font-size:15px; text-align: left;"><?php echo number_format($total, 0, ',', '.'); ?> đ</td>
            </tr>
        </table>

        <div style="display: flex; justify-content: space-between; margin-top: 15px;">
            <a href="nhiemvu15.php?action=clear" class="btn-c btn-c-gray" onclick="return confirm('Xóa sạch giỏ hàng?')">Xóa tất cả</a>
            <div>
                <a href="nhiemvu13.php" class="btn-c btn-c-gray">&laquo; Mua tiếp</a>
                <button type="submit" name="btnUpdateCart" class="btn-c">Cập nhật số lượng</button>
            </div>
        </div>
    </form>
    <form method="GET" action="nhiemvu15.php" style="display: flex; justify-content: flex-end; margin-top: 8px;">
        <input type="hidden" name="action" value="checkout">
        <button type="submit" class="btn-c btn-c-red" onclick="return confirm('Xác nhận thanh toán? Số lượng sản phẩm sẽ được trừ sau khi đặt hàng.')">💳 Thanh Toán</button>
    </form>
    <?php if (!empty($_SESSION['checkout_errors'])): ?>
        <div style="margin-top:10px; padding:10px; background:#ffebee; border:1px solid #ef9a9a; border-radius:4px; color:#c62828;">
            <b>⚠️ Không thể thanh toán:</b>
            <ul style="margin:5px 0 0 20px;">
                <?php foreach ($_SESSION['checkout_errors'] as $err): unset($_SESSION['checkout_errors']); ?>
                    <li><?php echo $err; ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
<?php endif; ?>

<?php
mysqli_close($conn);
include "includes/footer.php";
?>
