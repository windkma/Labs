<?php
$pageTitle = 'Nhiệm vụ 13 - Cửa hàng laptop';
$pageClass = 'task-13';
require_once __DIR__ . '/includes/database.php';
$conn = connect_database('laptop_shop', 'sql/laptop_shop.sql');

include "includes/header.php";

$action = $_GET['action'] ?? 'list';
$cat_id = isset($_GET['cat']) ? (int)$_GET['cat'] : 0;
$keyword = trim($_GET['keyword'] ?? '');
?>

<style>
.shop-layout { display: flex; gap: 15px; margin-top: 10px; }
.shop-sidebar { width: 180px; flex-shrink: 0; }
.shop-sidebar h4 { background: #333; color: #fff; padding: 8px; font-size: 13px; text-transform: uppercase; margin-bottom: 0; }
.shop-sidebar ul { list-style: none; border: 1px solid #ccc; border-top: none; }
.shop-sidebar li a { display: block; padding: 7px 10px; border-bottom: 1px solid #eee; text-decoration: none; color: #333; font-size: 12px; }
.shop-sidebar li a:hover, .shop-sidebar li.active a { background: #ffeb3b; font-weight: bold; color: #d32f2f; }
.shop-content { flex: 1; }
.shop-search { display: flex; justify-content: space-between; align-items: center; background: #eee; padding: 8px 12px; margin-bottom: 15px; border-radius: 4px; }
.p-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 15px; }
.p-card { border: 1px solid #ddd; padding: 10px; background: #fff; border-radius: 4px; display: flex; flex-direction: column; justify-content: space-between; }
.p-card img { width: 100%; height: 120px; object-fit: contain; }
.p-card h5 { margin: 8px 0 5px; font-size: 13px; }
.p-card h5 a { text-decoration: none; color: #0066cc; }
.p-price { color: #d32f2f; font-weight: bold; font-size: 14px; margin-bottom: 8px; }
.btn-detail { display: inline-block; padding: 4px 10px; background: #2196F3; color: white; text-decoration: none; font-size: 12px; border-radius: 3px; text-align: center; }
.p-stock { font-size: 12px; margin-bottom: 6px; }
.p-stock.in-stock { color: #27ae60; font-weight: bold; }
.p-stock.out-stock { color: #d32f2f; font-weight: bold; }
.btn-disabled { display: inline-block; padding: 4px 10px; background: #aaa; color: white; font-size: 12px; border-radius: 3px; cursor: not-allowed; }
</style>

<h3>Nhiệm vụ 13: Web Bán Laptop (End User)</h3>

<?php if ($action === 'detail'): ?>
    <?php
    $id = (int)($_GET['id'] ?? 0);
    $rs = mysqli_query($conn, "SELECT p.*, c.name AS cat_name FROM products p LEFT JOIN categories c ON p.category_id = c.id WHERE p.id = $id");
    $p = mysqli_fetch_assoc($rs);
    ?>
    <?php if ($p): ?>
        <div style="margin-top: 15px; border: 1px solid #ddd; padding: 15px; background: #fff;">
            <h4>Chi tiết sản phẩm: <?php echo htmlspecialchars($p['name']); ?></h4>
            <div style="display: flex; gap: 20px; margin-top: 15px;">
                <img src="img/<?php echo htmlspecialchars($p['image']); ?>" onerror="this.src='img/avatar.png'" style="width: 180px; height: 150px; object-fit: contain; border: 1px solid #eee;">
                <div>
                    <p><b>Thương hiệu:</b> <?php echo htmlspecialchars($p['cat_name']); ?></p>
                    <p class="p-price" style="font-size: 18px; margin: 10px 0;"><?php echo number_format($p['price'], 0, ',', '.'); ?> VNĐ</p>
                    <?php if ((int)$p['sl'] > 0): ?>
                        <p class="p-stock in-stock">✅ Còn hàng: <?php echo (int)$p['sl']; ?> sản phẩm</p>
                        <a href="nhiemvu15.php?action=add&id=<?php echo $p['id']; ?>" class="btn-detail" style="background:#d32f2f; padding: 6px 15px;">🛒 Thêm vào giỏ hàng</a>
                    <?php else: ?>
                        <p class="p-stock out-stock">❌ Hết hàng</p>
                        <span class="btn-disabled" style="padding: 6px 15px;">🛒 Thêm vào giỏ hàng</span>
                    <?php endif; ?>
                </div>
            </div>
            <hr style="margin: 15px 0;">
            <b>Mô tả & Cấu hình chi tiết:</b>
            <div style="font-size: 13px; line-height: 1.6; margin-top: 8px;"><?php echo $p['description']; ?></div>
            <br>
            <a href="nhiemvu13.php">&laquo; Quay lại danh sách laptop</a>
        </div>
    <?php endif; ?>

<?php else: ?>    
    <div class="shop-search">
        <span><b>Danh mục sản phẩm</b></span>
        <form method="GET" action="nhiemvu13.php" style="display: flex; gap: 5px;">
            <input type="text" name="keyword" placeholder="Tìm kiếm laptop..." value="<?php echo htmlspecialchars($keyword); ?>" style="padding: 4px 8px; font-size: 12px;">
            <button type="submit" style="padding: 4px 10px; cursor: pointer;">Tìm</button>
        </form>
    </div>

    <div class="shop-layout">
        <div class="shop-sidebar">
            <h4>Hãng Laptop</h4>
            <ul>
                <li class="<?php echo ($cat_id == 0) ? 'active' : ''; ?>"><a href="nhiemvu13.php">Tất cả hãng</a></li>
                <?php
                $rs_c = mysqli_query($conn, "SELECT * FROM categories");
                while ($cat = mysqli_fetch_assoc($rs_c)) {
                    $active = ($cat_id == $cat['id']) ? 'active' : '';
                    echo "<li class='$active'><a href='nhiemvu13.php?cat={$cat['id']}'>{$cat['name']}</a></li>";
                }
                ?>
            </ul>
        </div>

        <div class="shop-content">
            <?php
            $sql = "SELECT p.*, c.name AS cat_name FROM products p LEFT JOIN categories c ON p.category_id = c.id WHERE 1=1";
            if ($cat_id > 0) $sql .= " AND p.category_id = $cat_id";
            if (!empty($keyword)) {
                $kw_safe = mysqli_real_escape_string($conn, $keyword);
                $sql .= " AND (p.name LIKE '%$kw_safe%' OR p.description LIKE '%$kw_safe%')";
            }
            $sql .= " ORDER BY p.id DESC";
            $rs_p = mysqli_query($conn, $sql);
            ?>
            <div class="p-grid">
                <?php if (mysqli_num_rows($rs_p) > 0): ?>
                    <?php while ($p = mysqli_fetch_assoc($rs_p)): ?>
                        <div class="p-card">
                            <img src="img/<?php echo htmlspecialchars($p['image']); ?>" onerror="this.src='img/avatar.png'">
                            <h5><a href="nhiemvu13.php?action=detail&id=<?php echo $p['id']; ?>"><?php echo htmlspecialchars($p['name']); ?></a></h5>
                            <div class="p-price"><?php echo number_format($p['price'], 0, ',', '.'); ?> đ</div>
                            <?php if ((int)$p['sl'] > 0): ?>
                                <div class="p-stock in-stock">Còn: <?php echo (int)$p['sl']; ?> sp</div>
                            <?php else: ?>
                                <div class="p-stock out-stock">Hết hàng</div>
                            <?php endif; ?>
                            <div style="display:flex; justify-content:space-between; align-items:center;">
                                <a href="nhiemvu13.php?action=detail&id=<?php echo $p['id']; ?>" class="btn-detail">Chi tiết</a>
                                <?php if ((int)$p['sl'] > 0): ?>
                                    <a href="nhiemvu15.php?action=add&id=<?php echo $p['id']; ?>" class="btn-detail" style="background:#27ae60;">Đặt mua</a>
                                <?php else: ?>
                                    <span class="btn-disabled">Hết hàng</span>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p style="grid-column: 1/-1;">Không có sản phẩm nào phù hợp.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php
mysqli_close($conn);
include "includes/footer.php";
?>
